<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Book
 * @package app\models
 *
 * This is the model class for table 'book'.
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $author_id
 * @property int $pages
 * @property Author $author
 * @property string|null $search
 */
class Book extends ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public $search;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'book';
	}

	/**
	 * Gets the related Author model for the book.
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getAuthor()
	{
		return $this->hasOne(Author::class, ['id' => 'author_id']);
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['title', 'description', 'author_id', 'pages'], 'required'],
			[['title', 'description'], 'string'],
			[['author_id', 'pages'], 'integer'],
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
	 * @return Book|null the identity object that matches the given ID.
	 */
	public static function findIdentity($id)
	{
		return static::findOne($id);
	}

	/**
	 * Gets the primary key value.
	 *
	 * @return int the primary key value
	 */
	public function getId()
	{
		return $this->getPrimaryKey();
	}
}
