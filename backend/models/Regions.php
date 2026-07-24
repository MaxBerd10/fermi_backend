<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "regions".
 *
 * @property int $id
 * @property string|null $name
 */
class Regions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'regions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
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
            'name' => 'Name',
        ];
    }
    public static  function getRegions(){
        return Self::find()->asArray()->all();
    }
}
