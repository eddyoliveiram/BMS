<?php

namespace app\models;
use yii\db\ActiveRecord;

class Author extends ActiveRecord
{

	public static function tableName()
	{
		return 'author';
	}

	public function rules()
	{
		return [
			[
				['name'], 'required'
			],
			[['name'], 'string'],
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
