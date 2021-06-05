<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Roles extends Enum
{
	const ADMIN =   1;
	const PATIENT =   2;
	const ASSISTANT = 3;

	public static function getDescription($value): string
	{
			switch ($value) {
				case self::ADMIN:
					return 'Administrador';
					break;
				default:
					return parent::getDescription($value);
			}
	}
}
