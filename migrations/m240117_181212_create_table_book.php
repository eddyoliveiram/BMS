<?php

use Faker\Factory;
use yii\db\Migration;

/**
 * Class m240117_181212_create_table_book
 */
class m240117_181212_create_table_book extends Migration
{
	public function safeUp()
	{
		$this->createTable('book', [
			'id' => $this->primaryKey(),
			'title' => $this->string()->notNull(),
			'description' => $this->string()->notNull(),
			'author_id' => $this->integer()->notNull(),
			'pages' => $this->integer()->notNull(),
			'created_at' => $this->timestamp()->defaultExpression('NOW()')
		]);

		$this->addForeignKey(
			'fk-book-author_id',
			'book', 'author_id',
			'author','id',
			'CASCADE'
		);

		$Ids = $this->getDb()->createCommand('SELECT id FROM author')->queryColumn();
		$faker = Factory::create();

		foreach (range(1, 250) as $r) {
			$this->insert('book', [
				'title' => $faker->sentence,
				'description' => $faker->text,
				'author_id' => $Ids[array_rand($Ids)],
				'pages' => $faker->numberBetween(100, 1000),
				'created_at' => $faker->dateTimeThisDecade()->format('Y-m-d H:i:s'),
			]);
		}

	}

	public function safeDown()
	{
		$this->dropForeignKey('fk-book-author_id', 'book');
		$this->dropTable('book');
	}
}
