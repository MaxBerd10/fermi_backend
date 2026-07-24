<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "connect_leader".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 */
class ConnectLeader extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'connect_leader';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 200],
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
            'status' => 'Status',
        ];
    }
public static function getConnect()
{
    return Self::find()->where(['status'=>1])->asArray()->all();
}

}
