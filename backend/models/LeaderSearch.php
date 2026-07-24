<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Leader;

/**
 * LeaderSearch represents the model behind the search form of `backend\models\Leader`.
 */
class LeaderSearch extends Leader
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['name_uz', 'position_uz', 'position_en', 'position_ru',  'biography_uz', 'biography_ru', 'biography_en','activity_uz','activity_ru','activity_en',  'phone', 'faks', 'email', 'rasm','reception_days_uz','reception_days_en','reception_days_ru','name_en','name_ru'], 'safe'],
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
        $query = Leader::find();

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
            'status' => $this->status,
            'reception_days_uz'=>$this->reception_days_uz,
            'reception_days_en'=>$this->reception_days_en,
            'reception_days_ru'=>$this->reception_days_ru,


        ]);

        $query->andFilterWhere(['like', 'name_uz', $this->name_uz])
            ->andFilterWhere(['like', 'position_uz', $this->position_uz])
            ->andFilterWhere(['like', 'position_en', $this->position_en])
            ->andFilterWhere(['like', 'position_ru', $this->position_ru])
            ->andFilterWhere(['like', 'biography_uz', $this->biography_uz])
            ->andFilterWhere(['like', 'biography_ru', $this->biography_ru])
            ->andFilterWhere(['like', 'biography_en', $this->biography_en])
            ->andFilterWhere(['like', 'biography_uz', $this->activity_uz])
            ->andFilterWhere(['like', 'biography_ru', $this->activity_ru])
            ->andFilterWhere(['like', 'biography_en', $this->activity_uz])
            ->andFilterWhere(['like', 'name_en', $this->name_en])
            ->andFilterWhere(['like', 'name_ru', $this->name_ru])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'faks', $this->faks])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'rasm', $this->rasm]);

        return $dataProvider;
    }
}
