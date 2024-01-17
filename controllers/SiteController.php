<?php
namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends Controller
{

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::class,
				'only' => ['login','signup','logout'],
				'rules' => [
					[
						//? = guests
						'allow' => true,
						'actions' => ['login', 'signup'],
						'roles' => ['?'],
					],
					[
						//@ = auth
						'allow' => true,
						'actions' => ['logout'],
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					'logout' => ['post'],
					'login' => ['get'],
					'attempt' => ['post'],
				],
			],
		];
	}

	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	public function actionIndex()
	{
		if (!Yii::$app->user->isGuest)
			return $this->redirect(['book/index']);

		$model = new LoginForm();
		return $this->render('login', [
			'model' => $model,
		]);
	}

	public function actionAttempt()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		$model->load(Yii::$app->request->post());
//		dd($model);
		$user = User::findByUsernameAndPassword($model->username, $model->password);

		if(!$user){
			Yii::$app->session->setFlash('error', "Credentials not found.");
			return $this->redirect('login');
		}

		if (!Yii::$app->user->login($user)) {
			Yii::$app->session->setFlash('error', "Unfortunately the login has failed.");
			return $this->redirect('login');
		}

		return $this->redirect(['book/index']);

	}

	public function actionLogin()
	{
		$model = new LoginForm();
		$model->password = '';
		return $this->render('login', [
			'model' => $model,
		]);
	}

	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}

	public function actionSignup()
	{
		$model = new LoginForm();
		$model->password = '';
		return $this->render('signup', [
			'model' => $model,
		]);
	}

	public function actionRegister()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		$model->load(Yii::$app->request->post());

		$user = new User();
		$user->username = $model->username;
		$user->password = Yii::$app->security->generatePasswordHash($model->password);

		$anotherUserHasTakenUsername = User::findByUsername($model->username);

		if($anotherUserHasTakenUsername){
			Yii::$app->session->setFlash('error', "Unfortunately this Username has already been taken.");
			return $this->redirect(['site/signup']);
		}

		if (!$user->customSave()) {
			Yii::$app->session->setFlash('error', "Unfortunately the registration failed.");
			return $this->redirect(['site/signup']);
		}

		$user = User::findByUsernameAndPassword($model->username, $model->password);

		if (!Yii::$app->user->login($user)) {
			Yii::$app->session->setFlash('error', "Unfortunately the login has failed.");
			return $this->redirect('login');
		}

		Yii::$app->session->setFlash('success', "You have been registered successfully, enjoy it.");
		return $this->redirect(['book/index']);

	}

}
