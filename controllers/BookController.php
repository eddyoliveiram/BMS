<?php

namespace app\controllers;

use app\models\Book;
use app\models\BookForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
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
                'only' => ['index, create, store, edit, update'],
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
                    'index' => ['get'],
					'store' => ['post'],

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




	public function actionUpdateTwo($id)
	{
		$model = Book::findOne($id);

		if (!$model) {
			Yii::$app->session->setFlash('error', 'Failed to identify the book.');
			return $this->render('create', ['model' => $model]);
		}

		if (!$model->validate()) {
			Yii::$app->session->setFlash('error', 'Failed to validate form.');
			return $this->render('edit', ['model' => $model]);
		}

		if (!$model->save()) {
			Yii::$app->session->setFlash('error', 'Failed to save changes.');
			return $this->render('create', ['model' => $model]);
		}

		Yii::$app->session->setFlash('success', 'Changes were saved successfully.');
		return $this->redirect(['book/index']);
	}

	public function actionUpdate2($id)
	{
		$model = Book::findOne($id);

		$model->title = Yii::$app->request->post('Book')['title'];
		$model->description = Yii::$app->request->post('Book')['description'];
		$model->author_id = Yii::$app->request->post('Book')['author_id'];
		$model->pages = Yii::$app->request->post('Book')['pages'];

		if (!$model->validate()) {
			Yii::$app->session->setFlash('error', 'Failed to validate form.');
			return $this->render('create', ['model' => $model]);
		}

		dd($model);
//
//		$book = new Book();
//		$book->title = $model->title;
//		$book->description = $model->description;
//		$book->author_id = $model->author_id;
//		$book->pages = $model->pages;
//		$book->created_at = Yii::$app->formatter->asDate('now');

		if (!$model->save()) {
			Yii::$app->session->setFlash('error', 'Failed to save changes.');
			return $this->render('create', ['model' => $model]);
		}

		Yii::$app->session->setFlash('success', 'Changes were saved successfully.');
		return $this->redirect(['book/index']);
	}


	public function actionDestroy()
	{
		$id = Yii::$app->request->get('id');
//		return $this->render('edit', ['id' => $id]);
	}


}
