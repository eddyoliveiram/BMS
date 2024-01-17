<?php

use Faker\Factory;
use yii\db\Migration;

/**
 * Class m240117_181158_create_table_author
 */
class m240117_181158_create_table_author extends Migration
{
	public function safeUp()
	{
		$this->createTable('author', [
			'id' => $this->primaryKey(),
			'name' => $this->string()->notNull()
		]);

		$faker = Factory::create();

		foreach (range(1, 10) as $r) {
			$this->insert('author', [
				'name' => $faker->name,
			]);
		}
	}

	public function safeDown()
	{
		$this->dropTable('author');
	}
}
