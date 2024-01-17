<?php

namespace app\models;
use yii\db\ActiveRecord;

class Book extends ActiveRecord
{

	public static function tableName()
	{
		return 'book';
	}

	public function rules()
	{
		return [
			[
				['title', 'description', 'author_id', 'pages', 'created_at'], 'required'
			],
			[['title'], 'string'],
			[['description'], 'string'],
			[['author_id'], 'integer'],
			[['pages'], 'integer'],
			[['created_at'], 'date'],
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
