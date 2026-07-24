<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Virtual;

/**
 * VirtualSearch represents the model behind the search form of `backend\models\Virtual`.
 */
class VirtualSearch extends Virtual
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'province', 'fog', 'faculty_id', 'status'], 'integer'],
            [['fish', 'address', 'phone', 'email', 'gender', 'text', 'file'], 'safe'],
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
        $query = Virtual::find();

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
            'province' => $this->province,
            'fog' => $this->fog,
            'faculty_id' => $this->faculty_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'fish', $this->fish])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'file', $this->file]);

        return $dataProvider;
    }
}
