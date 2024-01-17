<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">
                        <?= Html::encode($this->title) ?>
                    </h2>
					<?php $form = ActiveForm::begin([
						'id' => 'login-form',
						'action' => ['site/attempt'],
						'fieldConfig' => [
							'template' => "{label}\n{input}\n{error}",
							'labelOptions' => ['class' => 'col-form-label mr-lg-3'],
							'inputOptions' => ['class' => 'col-lg-3 form-control'],
							'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
						],
					]); ?>
					<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
					<?= $form->field($model, 'password')->passwordInput() ?>

                    <div class="form-group text-center">
                        <div>
							<?= Html::submitButton('Login', ['class' => 'btn btn-primary w-100', 'name' => 'login-button']) ?>
                        </div>
                    </div>

					<?php ActiveForm::end(); ?>
                    <hr class="my-4">
                    <p class="text-center mb-0 small">Don't have an account? <a href="/register" class="small">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>
</div>