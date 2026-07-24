<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Logo;

/**
 * LogoSearch represents the model behind the search form of `backend\models\Logo`.
 */
class LogoSearch extends Logo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['title_uz', 'title_ru', 'title_en', 'subtitle_uz', 'subtitle_ru', 'subtitle_en', 'img'], 'safe'],
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
        $query = Logo::find();

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
        ]);

        $query->andFilterWhere(['like', '$this->title_uz', $this->title_uz])
            ->andFilterWhere(['like', 'title_ru', $this->title_ru])
            ->andFilterWhere(['like', 'title_en', $this->title_en])
            ->andFilterWhere(['like', 'subtitle_uz', $this->subtitle_uz])
            ->andFilterWhere(['like', 'subtitle_ru', $this->subtitle_ru])
            ->andFilterWhere(['like', 'subtitle_en', $this->subtitle_en])
            ->andFilterWhere(['like', 'img', $this->img]);

        return $dataProvider;
    }
}
