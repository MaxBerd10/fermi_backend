<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Counter;

/**
 * CounterSearch represents the model behind the search form of `backend\models\Counter`.
 */
class CounterSearch extends Counter
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'professor_teachers', 'students', 'graduaters', 'book_fund', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Counter::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'professor_teachers' => $this->professor_teachers,
            'students' => $this->students,
            'graduaters' => $this->graduaters,
            'book_fund' => $this->book_fund,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
