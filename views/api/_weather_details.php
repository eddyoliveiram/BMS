<?php
use yii\grid\GridView;
use app\helpers\WeatherHelper;
?>
<div class="table-responsive">
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
					return WeatherHelper::translateDayOfWeek($model['weekday']);
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
