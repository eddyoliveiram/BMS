<?php

namespace app\controllers;

use app\models\Book;
use app\models\BookForm;
use app\models\BookSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class BookController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
				'only' => ['index', 'create', 'store', 'edit', 'update', 'destroy'],
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
                        'actions' => ['index', 'create', 'store', 'edit', 'update', 'destroy'],
						'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get'],
					'store' => ['post'],
					'edit' => ['get'],
					'update' => ['post'],
					'destroy' => ['get'],
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

	public function actionIndex($search = null)
	{
		$searchModel = new BookSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}



	public function actionCreate()
	{
		$model = new BookForm();
		return $this->render('create', ['model' => $model]);
	}

	public function actionStore()
	{
		$model = new BookForm();

		if (!$model->load(Yii::$app->request->post()) || !$model->validate()) {
			Yii::$app->session->setFlash('error', 'Failed to validate form.');
			return $this->render('create', ['model' => $model]);
		}

		$book = new Book();
		$book->attributes = $model->attributes;
		$book->created_at = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');

		if (!$book->save()) {
			Yii::$app->session->setFlash('error', 'Failed to add new book.');
			return $this->render('create', ['model' => $model]);
		}

		Yii::$app->session->setFlash('success', 'Book added successfully.');
		return $this->redirect(['book/index']);

	}

	public function actionEdit($id)
	{
		$book = Book::findOne($id);

		if (!$book) {
			Yii::$app->session->setFlash('error', 'Failed to identify the book.');
			return $this->redirect(['book/index']);
		}

		$model = new BookForm();
		$model->attributes = $book->attributes;

		return $this->render('edit', [
			'model' => $model,
		]);
	}

	public function actionUpdate($id)
	{
		$book = Book::findOne($id);

		if (!$book) {
			Yii::$app->session->setFlash('error', 'Failed to identify the book.');
			return $this->redirect(['book/create']);
		}

		$model = new BookForm();
		$model->attributes = $book->attributes;

		if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate()) {

			$book->attributes = $model->attributes;

			if ($book->save()) {
				Yii::$app->session->setFlash('success', 'Book updated successfully.');
				return $this->redirect(['book/index']);
			} else {
				Yii::$app->session->setFlash('error', 'Failed to update the book.');
				return $this->render('create', ['model' => $model]);
			}
		}

	}

	public function actionDestroy($id)
	{
		$model = Book::findOne($id);

		if (!$model) {
			Yii::$app->session->setFlash('error', 'Failed to find the book.');
			return $this->redirect(['index']);
		}

		if (!$model->delete()) {
			Yii::$app->session->setFlash('error', 'Failed to delete the book.');
			return $this->redirect(['index']);
		}

		Yii::$app->session->setFlash('success', 'Book deleted successfully.');
		return $this->redirect(['index']);
	}

}
