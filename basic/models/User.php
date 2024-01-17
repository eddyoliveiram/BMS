<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
	public $username;
	public $password;
	public $authKey;

	public static function tableName()
	{
		return 'user';
	}

	public function rules()
	{
		return [
			[['username', 'password'], 'required'],
			[['username'], 'string'],
			[['password'], 'string'],
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

	/**
	 * {@inheritdoc}
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
//		foreach (self::$users as $user) {
//			if ($user['accessToken'] === $token) {
//				return new static($user);
//			}
//		}

		return null;
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findByUsername($username)
	{
		$user = static::findOne(['username' => $username]);
		return $user ?? null;

	}

public static function findByUsernameAndPassword($username, $password)
	{
		$user = static::findOne(['username' => $username]);
		if ($user == null) {
			return null;
		}

		if(! Yii::$app->security->validatePassword($password, $user->getAttribute('password')) ){
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
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return bool if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return $this->password === $password;
	}

	public function customSave() : bool
	{
		$columns = [
			'username' => $this->username,
			'password' => $this->password
		];
		$table = $this->tableName();
		if(!$this->db->createCommand()->insert($table, $columns)->execute()){
			return false;
		}
		return true;
	}

}
