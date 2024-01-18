<?php
use yii\grid\GridView;

$this->title = 'Weather Info';

function translateDayOfWeek($dayOfWeek)
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

// Filter the forecast array to include only the current day
$currentDayForecast = array_filter($data['results']['forecast'], function ($forecast) {
	$currentDate = date('d/m');
	return $forecast['date'] == $currentDate;
});

?>

<h1 class="mt-2 mb-3">
	<?= $data['results']['temp'].'º C | '.$data['results']['city'];?>
</h1>
<h3 class="mt-2 mb-4">Today's Weather Forecast</h3>

<div class="site-index">
	<?= GridView::widget([
		'dataProvider' => new \yii\data\ArrayDataProvider([
			'allModels' => $currentDayForecast,
			'pagination' => false, // Disable pagination for only one day
		]),
		'columns' => [
			'date',
			[
				'attribute' => 'weekday',
				'label' => 'Day of the Week',
				'value' => function ($model) {
					return translateDayOfWeek($model['weekday']);
				},
			],
			[
				'attribute' => 'rain_probability',
				'label' => 'Rain Probability (%)',
			],
			'max',
			'min',
			'cloudiness',
			'rain',
			'wind_speedy',
		],
	]); ?>
</div>
