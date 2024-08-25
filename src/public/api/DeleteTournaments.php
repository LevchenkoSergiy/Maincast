<?php


require __DIR__ . '/../../vendor/autoload.php';

use Maincast\App\Classes\TournamentHandler;


header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if ($id === null || !is_numeric($id)) {
	http_response_code(400);
	echo json_encode(['status' => 'error', 'message' => 'Неправильний або відсутній ID.']);
	exit;
}

try {
	TournamentHandler::deleteById((int)$id);
	echo json_encode(['status' => 'success', 'message' => 'Турнір успішно видалено.']);
} catch (Exception $e) {
	http_response_code(404);
	echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
