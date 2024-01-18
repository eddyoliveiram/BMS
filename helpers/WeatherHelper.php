<?php

namespace app\helpers;

class WeatherHelper
{
	public static function translateDayOfWeek($dayOfWeek)
	{
		$translation = [
			'Dom' => 'Sunday',
			'Seg' => 'Monday',
			'Ter' => 'Tuesday',
			'Qua' => 'Wednesday',
			'Qui' => 'Thursday',
			'Sex' => 'Friday',
			'Sáb' => 'Saturday',
		];

		return isset($translation[$dayOfWeek]) ? $translation[$dayOfWeek] : $dayOfWeek;
	}
}
