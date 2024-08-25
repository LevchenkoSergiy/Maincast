<?php

namespace Maincast\App\Classes;
use Maincast\App\Enums\GameType;

class TournamentHandler
{
	protected $tournament;
	protected $id;

	public function __construct(Tournament $tournament, $id = null)
	{
		$this->tournament = $tournament;
		$this->id = $id;
	}

	private function insertDb()
	{
		$dbConnection = Database::getInstance()->getConnection();
		$stmt = $dbConnection->prepare("INSERT INTO tournaments (title, game_type, stage, prize_pool, is_live, description, start_date, end_date, url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
		if ($stmt === false) {
			throw new \Exception("Помилка підготовки запиту на вставку в базу даних: " . $dbConnection->error);
		}

		$title = $this->tournament->getTitle();
		$gameType = $this->tournament->getGameType()->value;
		$stage = $this->tournament->getStage();
		$prizePool = $this->tournament->getPrizePool();
		$isLive = $this->tournament->getIsLive() ? 1 : 0;
		$description = $this->tournament->getDescription();
		$start_date = $this->tournament->getStartDate();
		$end_date = $this->tournament->getEndDate();
		$url = $this->tournament->getUrl();

		$stmt->bind_param("sssdissss", $title, $gameType, $stage, $prizePool, $isLive, $description, $start_date, $end_date, $url);
		if ($stmt->execute() === false) {
			throw new \Exception("Помилка виконання запиту на вставку в базу даних: " . $stmt->error);
		}

		$this->id = $stmt->insert_id;
	}
	public function saveDb()
	{
		if ($this->id === null) {
			$this->insertDb();
		}
	}

	public function getAllTournaments()
	{
		$dbConnection = Database::getInstance()->getConnection();
		$query = "SELECT title, game_type, stage, prize_pool, is_live, description, start_date, end_date, url FROM tournaments";
		$result = $dbConnection->query($query);

		if ($result === false) {
			throw new \Exception("Помилка запиту до бази даних: " . $dbConnection->error);
		}

		$tournaments = [];
		while ($row = $result->fetch_assoc()) {
			$gameType = GameType::fromValue($row['game_type']);
			$tournament = new Tournament(
				$row['title'],
				$gameType,
				$row['stage'],
				$row['prize_pool'],
				$row['is_live'],
				$row['description'],
				$row['start_date'],
				$row['end_date'],
				$row['url']
			);
			$tournaments[] = $tournament;
		}

		return $tournaments;
	}
	public static function getLiveTournaments()
	{
		$dbConnection = Database::getInstance()->getConnection();
		$query = "SELECT * FROM tournaments WHERE is_live = 1";
		$result = $dbConnection->query($query);

		if ($result === false) {
			throw new \Exception("Помилка запиту до бази даних: " . $dbConnection->error);
		}

		$tournaments = [];
		while ($row = $result->fetch_assoc()) {
			$gameType = GameType::fromValue($row['game_type']);
			$tournaments[] = new Tournament(
				$row['title'],
				$gameType,
				$row['stage'],
				$row['prize_pool'],
				$row['is_live'],
				$row['description'],
				$row['start_date'],
				$row['end_date'],
				$row['url']
			);
		}

		return $tournaments;
	}
	public static function fetchById($id)
	{
		$dbConnection = Database::getInstance()->getConnection();
		$stmt = $dbConnection->prepare("SELECT * FROM tournaments WHERE id = ?");
		if ($stmt === false) {
			throw new \Exception("Помилка підготовки запиту для отримання турніру з бази даних.");
		}

		$stmt->bind_param("i", $id);
		if (!$stmt->execute()) {
			throw new \Exception("Помилка виконання запиту для отримання турніру з бази даних.");
		}

		$result = $stmt->get_result();
		$tournamentData = $result->fetch_assoc();
		if ($tournamentData === null) {
			throw new \Exception("Турнір з ID = {$id} не знайдено.");
		}

		return $tournamentData;
	}
	public static function deleteById($id)
	{
		$ad = self::fetchById($id);
		$dbConnection = Database::getInstance()->getConnection();
		$stmt = $dbConnection->prepare("DELETE FROM tournaments WHERE id = ?");
		if ($stmt === false) {
			throw new \Exception ("Помилка підготовки запиту на видалення турніру з бази даних");
		}

		$stmt->bind_param("i", $id);
		if (!$stmt->execute()) {
			throw new \Exception("Помилка видалення оголошення з бази даних");
		}
	}
}