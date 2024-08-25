<?php

require __DIR__ . '/../../vendor/autoload.php';

use Maincast\App\Classes\Tournament;
use Maincast\App\Classes\TournamentHandler;
use Maincast\App\Enums\GameType;

header('Content-Type: application/json');

try {
	$data = json_decode(file_get_contents('php://input'), true);

	$title = $data['title'] ?? '';
	$gameTypeValue = $data['gameType'] ?? '';
	$gameType = GameType::fromValue($gameTypeValue);
	$stage = $data['stage'] ?? '';
	$prizePool = isset($data['prizePool']) ? (float)$data['prizePool'] : 0.0;
	$isLive = isset($data['isLive']) ? true : false;
	$description = $data['description'] ?? '';
	$startDate = $data['startDate'] ?? '';
	$endDate = $data['endDate'] ?? '';
	$url = $data['url'] ?? '';

	$tournament = new Tournament($title, $gameType, $stage, $prizePool, $isLive, $description, $startDate, $endDate, $url);
	$tournamentHandler = new TournamentHandler($tournament);
	$tournamentHandler->saveDb();

	http_response_code(201);
	echo json_encode(['status' => 'success', 'message' => 'Турнір успішно додано.']);
} catch (Exception $e) {
	http_response_code(500);
	echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
