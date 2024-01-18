<?php
namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class IndexController extends Controller
{
	/**
	 * Set up access control rules and HTTP verbs for the actions.
	 *
	 * @return array
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::class,
				'only' => ['index','login','signup','logout'],
				'rules' => [
					[
						//? = guests
						'allow' => true,
						'actions' => ['index','login', 'signup', 'attempt'],
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

	/**
	 * Define actions for handling errors and captcha.
	 *
	 * @return array
	 */
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

	/**
	 * Displays the login form on the index page.
	 * Initializes a new instance of the LoginForm model.
	 *
	 * @return string The rendered login view.
	 */
	public function actionIndex()
	{
		$model = new LoginForm();
		return $this->render('login', [
			'model' => $model,
		]);
	}

	/**
	 * Attempts to log in the user based on the provided credentials.
	 * Redirects to the book/index page on successful login, or redisplays the login form on failure.
	 *
	 * @return \yii\web\Response
	 */
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

	/**
	 * Displays the login form.
	 * Initializes a new instance of the LoginForm model.
	 *
	 * @return string
	 */
	public function actionLogin()
	{
		$model = new LoginForm();

		return $this->render('login', [
			'model' => $model,
		]);
	}

	/**
	 * Logs the user out and redirects to the home page.
	 *
	 * @return \yii\web\Response
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();
		return $this->goHome();
	}

	/**
	 * Displays the signup form.
	 * Initializes a new instance of the LoginForm model.
	 *
	 * @return string
	 */
	public function actionSignup()
	{
		$model = new LoginForm();

		return $this->render('signup', [
			'model' => $model,
		]);
	}

	/**
	 * Registers a new user.
	 * If successful, logs in the new user and redirects to the book/index page.
	 * If unsuccessful, displays an error flash message and redirects to the signup page.
	 *
	 * @return \yii\web\Response
	 */

	public function actionRegister()
	{
		$model = new LoginForm();
		$model->load(Yii::$app->request->post());

		$user = new User();
		$user->username = $model->username;
		$user->password = Yii::$app->security->generatePasswordHash($model->password);

		$anotherUserHasTakenUsername = User::findByUsername($model->username);

		if ($anotherUserHasTakenUsername) {
			Yii::$app->session->setFlash('error', "Unfortunately this Username has already been taken.");
			return $this->redirect(['index/signup']);
		}

		if (!$user->save()) {
			Yii::$app->session->setFlash('error', "Unfortunately the registration failed.");
			return $this->redirect(['index/signup']);
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
