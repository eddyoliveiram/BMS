<?php

use yii\grid\GridView;
use yii\helpers\Html;
//dd(Yii::$app->user->identity->getAttribute('username'));
echo 'Welcome, '.
	'<span style="color:green;font-size:20px;">'.
	Yii::$app->user->identity->getAttribute('username').
	'</span><BR>.';
//dd($dataProvider);
//echo '<pre>';var_dump($dataProvider->getModels());
$this->title = 'List of books';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<button type="submit" class="btn btn-success">Add new book</button>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'pager' => [
		'class' => yii\bootstrap5\LinkPager::class,
	],
	'columns' => [
		'title',
		'description',
		[
			'attribute' => 'author_id',
			'label' => 'Author',
		],
		'pages',
		'created_at',
		[
			'class' => 'yii\grid\ActionColumn',
			'template' => '{view} {update} {delete}',
			'buttons' => [
				'view' => function ($url, $model) {
					return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view', 'id' => $model->id]);
				},
				'update' => function ($url, $model) {
					return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $model->id]);
				},
				'delete' => function ($url, $model) {
					return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
						'data' => [
							'confirm' => 'Are you sure you want to delete this item?',
							'method' => 'post',
						],
					]);
				},
			],
			'visibleButtons' => [
				'update' => function ($model, $key, $index) {
					return true; // Mostra o botão de atualização para todos os modelos
				},
				'delete' => function ($model, $key, $index) {
					return true; // Mostra o botão de exclusão para todos os modelos
				},
			],
		],
	],
]); ?>
