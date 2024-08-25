<?php

require __DIR__ . '/../vendor/autoload.php';

use Maincast\App\Classes\Tournament;
use Maincast\App\Classes\TournamentHandler;
use Maincast\App\Enums\GameType;

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$id = $_POST['id'] ?? null;
		$title = $_POST['title'] ?? '';
		$gameType = GameType::fromValue($_POST['gameType'] ?? '');
		$stage = $_POST['stage'] ?? '';
		$prizePool = isset($_POST['prizePool']) ? (float)$_POST['prizePool'] : 0.0;
		$isLive = isset($_POST['isLive']) ? true : false;
		$description = $_POST['description'] ?? '';
		$startDate = $_POST['startDate'] ?? '';
		$endDate = $_POST['endDate'] ?? '';
		$url = $_POST['url'] ?? '';

		$tournament = new Tournament($title, $gameType, $stage, $prizePool, $isLive, $description, $startDate, $endDate, $url );
		$tournamenthandler = new TournamentHandler($tournament, $id);

		$tournamenthandler->saveDb();
	}
} catch (Exception $e) {
	echo "Виникла помилка: " . $e->getMessage();
	echo "<br><a href='index.php'>Повернутися на початок</a>";
	exit;
}