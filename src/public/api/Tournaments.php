<?php
require __DIR__ . '/../../vendor/autoload.php';

use Maincast\App\Classes\Tournament;
use Maincast\App\Classes\TournamentHandler;
use Maincast\App\Enums\GameType;
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

try {
	$tournamentHandler = new TournamentHandler(new Tournament('', GameType::CSGO, '', 0, false, '', '', '', ''));
	$tournaments = $tournamentHandler->getAllTournaments();
	$tournamentData = [];

	foreach ($tournaments as $tournament) {
		$tournamentData[] = [
			'title' => $tournament->getTitle(),
			'game_type' => $tournament->getGameType()->value,
			'stage' => $tournament->getStage(),
			'prize_pool' => $tournament->getPrizePool(),
			'is_live' => $tournament->getIsLive(),
			'description' => $tournament->getDescription(),
			'start_date' => $tournament->getStartDate(),
			'end_date' => $tournament->getEndDate(),
			'url' => $tournament->getUrl(),
		];
	}

	echo json_encode(['status' => 'success', 'data' => $tournamentData]);
} catch (Exception $e) {
	http_response_code(500);
	echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}