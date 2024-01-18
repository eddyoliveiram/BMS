<?php
namespace app\models;

use yii\data\ActiveDataProvider;

/**
 * Class BookSearch
 * @package app\models
 *
 * This is the search model used for searching books with specific criteria.
 */
class BookSearch extends Book
{
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['title', 'description', 'author_id', 'pages'], 'safe'],
		];
	}

	/**
	 * Performs book search based on the provided parameters.
	 *
	 * @param array $params
	 * @return ActiveDataProvider
	 */
	public function search($params)
	{
		$query = Book::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere(['like', 'title', $this->title])
			->andFilterWhere(['like', 'description', $this->description])
			->andFilterWhere(['like', 'author_id', $this->author_id])
			->andFilterWhere(['like', 'pages', $this->pages]);

		return $dataProvider;
	}
}
