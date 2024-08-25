<?php

require __DIR__ . '/../../vendor/autoload.php';

use Maincast\App\Classes\Tournament;
use Maincast\App\Classes\TournamentHandler;
use Maincast\App\Classes\Database;
use Maincast\App\Enums\GameType;

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
try {
	if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
		http_response_code(405);
		echo json_encode(["message" => "Method Not Allowed"]);
		exit;
	}

	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

	// Валідація ID
	if ($id <= 0) {
		throw new Exception("Недійсний ID турніру.");
	}

	$inputData = json_decode(file_get_contents("php://input"), true);

	if (json_last_error() !== JSON_ERROR_NONE) {
		throw new Exception("Некоректний формат JSON.");
	}

	// Валідація вхідних даних
	$title = htmlspecialchars(strip_tags($inputData['title'] ?? ''));
	$gameTypeValue = htmlspecialchars(strip_tags($inputData['gameType'] ?? ''));
	$gameType = GameType::fromValue($gameTypeValue);
	$stage = htmlspecialchars(strip_tags($inputData['stage'] ?? ''));
	$prizePool = isset($inputData['prizePool']) ? (float)($inputData['prizePool']) : 0.0;
	$isLive = isset($inputData['isLive']) ? (bool)$inputData['isLive'] : false;
	$description = htmlspecialchars(strip_tags($inputData['description'] ?? ''));
	$startDate = htmlspecialchars(strip_tags($inputData['startDate'] ?? ''));
	$endDate = htmlspecialchars(strip_tags($inputData['endDate'] ?? ''));
	$url = htmlspecialchars(strip_tags($inputData['url'] ?? ''));

	// Перевірка наявності турніру
	$existingTournamentData = TournamentHandler::fetchById($id);

	if (!$existingTournamentData) {
		http_response_code(404);
		echo json_encode(["message" => "Турнір не знайдено."]);
		exit;
	}

	$tournament = new Tournament($title, $gameType, $stage, $prizePool, $isLive, $description, $startDate, $endDate, $url);
	$tournamentHandler = new TournamentHandler($tournament, $id);

	// Оновлення турніру в базі даних
	$dbConnection = Database::getInstance()->getConnection();
	$stmt = $dbConnection->prepare("UPDATE tournaments SET title = ?, game_type = ?, stage = ?, prize_pool = ?, is_live = ?, description = ?, start_date = ?, end_date = ?, url = ? WHERE id = ?");

	if ($stmt === false) {
		throw new Exception("Помилка підготовки запиту на оновлення.");
	}

	$gameTypeValue = $gameType->value;

	$stmt->bind_param("sssdissssi", $title, $gameTypeValue, $stage, $prizePool, $isLive, $description, $startDate, $endDate, $url, $id);

	if (!$stmt->execute()) {
		throw new Exception("Помилка виконання запиту на оновлення турніру.");
	}

	http_response_code(200);
	echo json_encode(["message" => "Турнір успішно оновлено."]);

} catch (Exception $e) {
	http_response_code(400);
	echo json_encode(["error" => $e->getMessage()]);
	exit;
}