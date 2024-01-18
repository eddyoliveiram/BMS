<?php
use app\models\User;
use yii\base\Security;
use yii\db\Migration;

/**
 * Class m240116_171854_create_faker_users
 */
class m240116_171854_create_faker_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$faker = \Faker\Factory::create();
		$security = new Security();

		$this->insert('user', [
			'username' => 'admin',
			'password' => $security->generatePasswordHash('admin')
		]);

		for ($i = 0; $i < 9; $i++) {
			$passwordForAllUsers = '123';
			$hashedPassword = $security->generatePasswordHash($passwordForAllUsers);

			$this->insert('user', [
				'username' => $faker->username,
				'password' => $hashedPassword
			]);
		}
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		User::deleteAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240116_171854_create_faker_users cannot be reverted.\n";

        return false;
    }
    */
}
