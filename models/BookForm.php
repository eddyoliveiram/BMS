<?php

namespace app\models;
use yii\base\Model;

class BookForm extends Model
{
	public $id;
	public $title;
	public $description;
	public $author_id;
	public $pages;
	public $created_at;

	public function rules()
	{
		return [
			[
				['title', 'description', 'author_id', 'pages'], 'required'
			],
			[['id'], 'integer'],
			[['title'], 'string'],
			[['description'], 'string'],
			[['author_id'], 'string'],
			[['pages'], 'string'],
		];
	}
}
