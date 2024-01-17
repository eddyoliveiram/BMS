<?php

use yii\db\Migration;
/**
 * Class m240116_161651_create_table_users
 */
class m240116_161651_create_table_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('user', [
			'id' => $this->primaryKey(),
			'username' => $this->string()->notNull(),
			'password' => $this->string()->notNull(),
		]);

		$this->createIndex('index_user_id', 'user', 'id', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		$this->dropIndex('index_user_id', 'user');
		$this->dropTable('user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240116_161651_create_table_users cannot be reverted.\n";

        return false;
    }
    */
}
