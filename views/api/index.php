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

?>

<h1 class="mt-2 mb-3">
	<?= $data['results']['temp'].'º C | '.$data['results']['city'];?>
</h1>
<h3>10-Day Weather Forecast</h3>

<div class="site-index">
	<?= GridView::widget([
		'dataProvider' => new \yii\data\ArrayDataProvider([
			'allModels' => $data['results']['forecast'],
			'sort' => [
				'attributes' => ['date', 'weekday', 'rain_probability'],
			],
			'pagination' => [
				'pageSize' => 10,
			],
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
