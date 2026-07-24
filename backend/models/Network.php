<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "network".
 *
 * @property int $id
 * @property string $titlte
 * @property string $icon
 * @property string $url
 * @property int $status
 */
class Network extends \yii\db\ActiveRecord
{
    const STATUS_SHOWED = 1;
    const STATUS_NOTSHOWED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'network';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titlte', 'icon', 'url', 'status'], 'required'],
            [['status'], 'integer'],
            [['titlte', 'icon', 'url'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titlte' => 'Titlte',
            'icon' => 'Icon',
            'url' => 'Url',
            'status' => 'Status',
        ];
    }
    public  static function getstatus()
    {
        return[
            self::STATUS_SHOWED=>"Faol",
            self::STATUS_NOTSHOWED=>"Faol emasl",
        ];
    }
    public  static  function  getNetwork(){
        return Self::find()->where(['status'=>1])->asArray()->all();
    }
}
