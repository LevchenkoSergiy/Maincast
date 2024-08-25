<?php

namespace Maincast\App\Classes;

use DateTime;
use Maincast\App\Enums\GameType;

class Tournament
{
	protected $title;
	protected $gameType;
	protected $stage;
	protected $prizePool;
	protected $isLive;
	protected $description;
	protected $startDate;
	protected $endDate;
	protected $url;

	public function __construct($title, GameType $gameType, $stage, $prizePool, $isLive, $description, $startDate, $endDate, $url)
	{
		$this->title = htmlspecialchars(strip_tags($title));
		$this->gameType = $gameType;
		$this->stage = htmlspecialchars(strip_tags($stage));
		$this->prizePool = htmlspecialchars(strip_tags($prizePool));
		$this->isLive = htmlspecialchars(strip_tags($isLive));
		$this->description = htmlspecialchars(strip_tags($description));
		$this->startDate = htmlspecialchars(strip_tags($startDate));
		$this->endDate = htmlspecialchars(strip_tags($endDate));
		$this->url = htmlspecialchars(strip_tags($url));
	}

	public function getTitle() {
		return $this->title;
	}

	public function getGameType(): GameType {
		return $this->gameType;
	}

	public function getStage() {
		return $this->stage;
	}

	public function getPrizePool() {
		return $this->prizePool;
	}

	public function getIsLive() {
		return $this->isLive;
	}

	public function getStartDate() {
		return $this->startDate;
	}

	public function getEndDate() {
		return $this->endDate;
	}

	public function getDescription() {
		return $this->description;
	}
	public function getUrl() {
		return $this->url;
	}
}