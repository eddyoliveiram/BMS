<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Author
 * @package app\models
 *
 * This is the model class for table 'author'.
 *
 * @property int $id
 * @property string $name
 */
class Author extends ActiveRecord
{

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'author';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['name'], 'string'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public static function primaryKey()
	{
		return ['id'];
	}

	/**
	 * Finds an identity by the given ID.
	 *
	 * @param int|string $id the ID to be looked for
	 * @return Author|null the identity object that matches the given ID.
	 */
	public static function findIdentity($id)
	{
		return static::findOne($id);
	}
}
