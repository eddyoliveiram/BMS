<?php

use kartik\date\DatePicker;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Book;

echo '<div class="text-center fs-5">' .
	'Welcome, ' .
	'<span style="color:green">' .
	Yii::$app->user->identity->getAttribute('username') .
	'</span>' .
	'</div>';

$this->title = 'Books';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= Html::button(
	'<i class="fas fa-book"></i> Add new book',
	[
		'class' => 'btn btn-success btn-lg mt-2 mb-2',
		'onclick' => 'location.href="/book/create"',
	]
) ?>
<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'class' => yii\bootstrap5\LinkPager::class,
            'options' => [
                'class' => 'd-flex justify-content-center',
                'style' => 'margin-top: 20px;',
            ],
        ],

        'columns' => [
            'title',
            'description',
            [
                'attribute' => 'author_id',
                'label' => 'Author',
                'value' => function ($model) {
                    return $model->author->name;
                },
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\Author::find()->asArray()->all(), 'id', 'name'),
            ],
            [
                'attribute' => 'pages',
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'created_at',
                'format' => ['datetime', 'php:m/d/Y h:i \G\M\T'],
                'contentOptions' => ['class' => 'text-center'],
    //			'filter' => Html::input('date', 'BookSearch[created_at]', isset(Yii::$app->request->get('BookSearch')['created_at']) ? Yii::$app->request->get('BookSearch')['created_at'] : '', ['class' => 'form-control', 'placeholder' => 'mm/dd/yyyy']),
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
                    $deleteUrl = ['destroy', 'id' => $model->id];
                    $confirmMessage = 'Are you sure you want to delete this item?';
                    $deleteButtonId = 'delete-button-' . $model->id;

                    $js = <<<JS
                    $("#{$deleteButtonId}").on("click", function() {
                        if (confirm("{$confirmMessage}")) {
                            var deleteUrl = "{$deleteUrl[0]}?id={$model->id}";
                            window.location.href = deleteUrl;
                        }
                    });
    JS;
                    $this->registerJs($js);

                    return Html::tag(
                        'div',
                        Html::a('<i class="fas fa-trash" style="color:red;font-size:22px"></i>', '#', [
                            'id' => $deleteButtonId,
                            'class' => 'delete-link',
                        ]),
                        ['class' => 'text-center']
                    );
                },
            ],
        ],
    ]); ?>
</div>