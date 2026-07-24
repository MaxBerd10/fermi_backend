<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Acceptance;

/**
 * AcceptanceSearch represents the model behind the search form of `backend\models\Acceptance`.
 */
class AcceptanceSearch extends Acceptance
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'region_id', 'district_id', 'quater_id','status'], 'integer'],
            [['date', 'subject', 'fish', 'phone', 'email'], 'safe'],
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
        $query = Acceptance::find();

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
            'status'=>$this->status,
            'category_id' => $this->category_id,
            'date' => $this->date,
            'region_id' => $this->region_id,
            'quater_id' => $this->quater_id,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'fish', $this->fish])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'district_id', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
