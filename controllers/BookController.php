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

	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::class,
				'only' => ['index', 'create', 'store', 'edit', 'update', 'destroy'],
				'rules' => [
					[
						// Allow authenticated users to access specified actions
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

	/**
	 * {@inheritdoc}
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
	 * Displays a list of books.
	 *
	 * @param null $search
	 * @return string
	 */
	public function actionIndex($search = null)
	{
		$searchModel = new BookSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays the book creation form.
	 *
	 * @return string
	 */
	public function actionCreate()
	{
		$model = new BookForm();
		return $this->render('create', ['model' => $model]);
	}

	/**
	 * Handles the book creation process.
	 *
	 * @return string|\yii\web\Response
	 */
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

	/**
	 * Displays the book editing form.
	 *
	 * @param $id
	 * @return string|\yii\web\Response
	 */
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

	/**
	 * Handles the book update process.
	 *
	 * @param $id
	 * @return string|\yii\web\Response
	 */
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

	/**
	 * Handles the book deletion process.
	 *
	 * @param $id
	 * @return \yii\web\Response
	 */
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