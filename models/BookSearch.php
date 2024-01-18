<?php
namespace app\models;
use yii\data\ActiveDataProvider;

class BookSearch extends Book
{
	public function rules()
	{
		return [
			[['title', 'description', 'author_id', 'pages'], 'safe'],
		];
	}

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
