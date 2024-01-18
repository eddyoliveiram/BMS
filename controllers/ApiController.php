<?php

namespace app\controllers;

use yii\httpclient\Client;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;


class ApiController extends Controller
{

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::class,
				'only' => ['index'],
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
						'actions' => ['index'],
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					'index' => ['get'],
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
		$apiUrl = 'https://api.hgbrasil.com/weather';

		$httpClient = new Client();
		$response = $httpClient->createRequest()
			->setMethod('GET')
			->setUrl($apiUrl)
			->send();

		if ($response->isOk) {
			$data = $response->data;
			return $this->render('index', ['data' => $data]);
		} else {
			Yii::error('Error: ' . $response->statusCode);

		}
	}

}
