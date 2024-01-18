<?php

namespace app\models;
use yii\db\ActiveRecord;

class Book extends ActiveRecord
{
	public $search;

	public static function tableName()
	{
		return 'book';
	}

	public function getAuthor()
	{
		return $this->hasOne(Author::class, ['id' => 'author_id']);
	}


	public function rules()
	{
		return [
			[
				['title', 'description', 'author_id', 'pages'], 'required'
			],
			[['title'], 'string'],
			[['description'], 'string'],
			[['author_id'], 'integer'],
			[['pages'], 'integer'],
		];
	}

	public static function primaryKey()
	{
		return ['id'];
	}

	public static function findIdentity($id)
	{
		return static::findOne($id);
	}

	public function getId()
	{
		return $this->getPrimaryKey();
	}


}
