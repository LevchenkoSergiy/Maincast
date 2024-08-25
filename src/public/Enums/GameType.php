<?php
namespace Maincast\App\Enums;

enum GameType: string {
	case CSGO = 'CS:GO';
	case DOTA2 = 'DOTA2';
	case Valorant = 'Valorant';

	public static function fromValue(string $value): self
	{
		return match ($value) {
			'CS:GO' => self::CSGO,
			'DOTA2' => self::DOTA2,
			'Valorant' => self::Valorant,
			default => throw new \Exception("Неправильний тип гри: $value"),
		};
	}
}

