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
			return $this->redirect(['home/index']);

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
			Yii::$app->session->setFlash('warning', "Credentials not found.");
			return $this->redirect('login');
		}

		if (Yii::$app->user->login($user)) {
			return $this->redirect(['home/index']);
		} else {
			return $this->render('error');
		}

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

}
