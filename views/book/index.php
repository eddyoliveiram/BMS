<?php
use yii\grid\GridView;
use yii\helpers\Html;

echo '<div class="text-center fs-5">'.
        'Welcome, '.
        '<span style="color:green">'.
        Yii::$app->user->identity->getAttribute('username').
        '</span>'.
    '</div>';

$this->title = 'List of books';
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= \yii\helpers\Html::button(
	'<i class="fas fa-book"></i> Add new book',
	[
            'class' => 'btn btn-success btn-lg mt-2 mb-2',
		'onclick' => 'location.href="/book/create"',
        ]
) ?>
<style>
    .custom-pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px; /* Adjust as needed */
    }
</style>
<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'pager' => [
		'class' => yii\bootstrap5\LinkPager::class,
		'options' => [
			'class' => 'd-flex justify-content-center',
			'style' => 'margin-top: 20px;'
		]
	],
	'columns' => [
		'title',
		'description',
		[
			'attribute' => 'author_id',
			'label' => 'Author',
		],
		'pages',
		[
			'attribute' => 'created_at',
			'format' => ['datetime', 'php:m/d/Y'],
		],
		[
			'label' => 'Edit',
			'format' => 'raw',
			'value' => function ($model) {
				return Html::tag(
					'div',
					Html::a('<i class="fas fa-pencil-alt" style="font-size:22px"></i>', ['edit', 'id' => $model->id]),
					['class' => 'text-center']
				);
			},
		],
		[
			'label' => 'Delete',
			'format' => 'raw',
			'value' => function ($model) {
				$deleteUrl = ['delete', 'id' => $model->id];
				$confirmMessage = 'Are you sure you want to delete this item?';

				return Html::tag(
					'div',
					Html::a('<i class="fas fa-trash" style="color:red;font-size:22px"></i>', '#', [
						'data' => [
							'confirm' => $confirmMessage,
							'method' => 'post',
							'url' => Yii::$app->urlManager->createUrl($deleteUrl),
						],
						'class' => 'delete-link',
					]),
					['class' => 'text-center']
				);
			},
		],
	],
]);

$this->registerJs('
    $(".delete-link").on("click", function() {
        var confirmMessage = $(this).data("confirm");
        var deleteUrl = $(this).data("url");

        if (confirm(confirmMessage)) {
            window.location.href = deleteUrl;
        }
    });
');
?>

