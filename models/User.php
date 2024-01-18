<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Class User
 * @package app\models
 *
 * This is the model class for the "user" table, representing user data and authentication methods.
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $authKey
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
	public $authKey;
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'user';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['username', 'password'], 'required'],
			[['username'], 'string'],
			[['password'], 'string'],
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
	 * @param int|string $id
	 * @return static|null
	 */
	public static function findIdentity($id)
	{
		return static::findOne($id);
	}

	/**
	 * Finds an identity by the given access token.
	 *
	 * Note that I haven't implemented this method yet, so it will always return null.
	 *
	 * @param string $token
	 * @param null $type
	 * @return null
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		return null;
	}

	/**
	 * Finds user by username.
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findByUsername($username)
	{
		$user = static::findOne(['username' => $username]);
		return $user ?? null;
	}

	/**
	 * Finds user by username and password.
	 *
	 * @param string $username
	 * @param string $password
	 * @return static|null
	 */
	public static function findByUsernameAndPassword($username, $password)
	{
		$user = static::findOne(['username' => $username]);

		if ($user === null || !Yii::$app->security->validatePassword($password, $user->getAttribute('password'))) {
			return null;
		}

		return $user;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getId()
	{
		return $this->getPrimaryKey();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAuthKey()
	{
		return $this->authKey;
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateAuthKey($authKey)
	{
		return $this->authKey === $authKey;
	}

	/**
	 * Validates password.
	 *
	 * @param string $password Password to validate
	 * @return bool If the provided password is valid for the current user
	 */
	public function validatePassword($password)
	{
		return $this->password === $password;
	}

}
