<?php
$this->title = 'Weather Info';
const DATE_FORMAT = 'd/m';

$currentDayForecast = array_filter($data['results']['forecast'], function ($forecast) {
	$currentDate = date(DATE_FORMAT);
	return $forecast['date'] == $currentDate;
});
?>

<h1 class="mt-2 mb-3">
	<?= $data['results']['temp'].'º C | '.$data['results']['city'];?>
</h1>

<h3 class="mt-2 mb-4">Today's Weather Forecast</h3>

<div class="site-index">
	<?= $this->render('_weather_details', [
		'currentDayForecast' => $currentDayForecast,
	]); ?>
</div>
