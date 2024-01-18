<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Add new book';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
	<div class="row justify-content-center mt-5">
		<div class="col-lg-4 ">
			<div class="card border-0 shadow">
				<div class="card-body p-4">
					<h2 class="text-center mb-4">
						<?= Html::encode($this->title) ?>
					</h2>
					<?php $form = ActiveForm::begin([
						'id' => 'book-form',
						'action' => ['book/store'],
						'method' => 'post',
						'fieldConfig' => [
							'template' => "{label}\n{input}\n{error}",
							'labelOptions' => ['class' => 'col-form-label mr-lg-3'],
							'inputOptions' => ['class' => 'col-lg-3 form-control'],
							'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
						],
					]); ?>
					<?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>
					<?= $form->field($model, 'description')->textInput() ?>
					<?= $form->field($model, 'author_id')->dropDownList(
						\yii\helpers\ArrayHelper::map(\app\models\Author::find()->all(), 'id', 'name'),
						['prompt' => ' - Select - ']
					)->label('Author') ?>

					<?= $form->field($model, 'pages')->input('number') ?>
					<div class="form-group text-center">
						<div>
							<?= Html::submitButton('<i class="fas fa-save"></i> Save',
                                ['class' => 'btn btn-primary w-100', 'name' => 'save-button', 'style' => 'height: 50px;']
                            ) ?>
							<?= Html::button(
								'<i class="fas fa-angle-left"></i> Back',
								[
									'class' => 'btn btn-secondary w-100 mt-2',
									'onclick' => 'location.href="/book/index"',
								]
							) ?>
						</div>
					</div>

					<?php ActiveForm::end(); ?>
				</div>
			</div>
		</div>
	</div>
</div>