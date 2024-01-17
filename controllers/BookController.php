<?php

namespace app\controllers;

use app\models\Book;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class BookController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['null'],
                'rules' => [
					[
						//? = guests
						'allow' => true,
						'actions' => ['null'],
						'roles' => ['?'],
					],
                    [
						//@ = auth
						'allow' => true,
                        'actions' => ['null'],
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
		$dataProvider = new ActiveDataProvider([
			'query' => Book::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider
		]);
    }

//	public function actionEdit()
//	{
//		$model = new LoginForm();
//		return $this->render('index', [
//			'att' => 'value '
//		]);
//	}


}
