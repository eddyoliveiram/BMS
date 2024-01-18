<?php

namespace app\models;

use yii\base\Model;

/**
 * Class BookForm
 * @package app\models
 *
 * This is the form model used for handling book data input and validation.
 *
 * @property int|null $id
 * @property string|null $title
 * @property string|null $description
 * @property int|null $author_id
 * @property int|null $pages
 * @property mixed|null $created_at
 */
class BookForm extends Model
{
	/**
	 * {@inheritdoc}
	 */
	public $id;
	public $title;
	public $description;
	public $author_id;
	public $pages;
	public $created_at;

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['title', 'description', 'author_id', 'pages'], 'required'],
			[['id', 'author_id', 'pages'], 'integer'],
			[['title', 'description'], 'string'],
		];
	}
}
