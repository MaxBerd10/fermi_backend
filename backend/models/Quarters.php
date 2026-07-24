<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "quarters".
 *
 * @property int $id
 * @property int $district_id
 * @property string|null $name
 */
class Quarters extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quarters';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['district_id'], 'required'],
            [['district_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'district_id' => 'District ID',
            'name' => 'Name',
        ];
    }
}
