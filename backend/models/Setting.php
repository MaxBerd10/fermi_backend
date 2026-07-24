<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property int $id
 * @property string $phone
 * @property string $email
 * @property string|null $faks
 * @property string $address_uz
 * @property string $address_ru
 * @property string $address_en
 * @property int $status
 */
class Setting extends \yii\db\ActiveRecord
{
    const STATUS_SHOWED = 1;
    const STATUS_NOTSHOWED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone', 'email', 'address_uz', 'address_ru', 'address_en', 'status'], 'required'],
            [['status'], 'integer'],
            [['email','phone'], 'string', 'max' => 40],
            [['faks', 'address_uz', 'address_ru', 'address_en'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Phone',
            'email' => 'Email',
            'faks' => 'Faks',
            'address_uz' => 'Address Uz',
            'address_ru' => 'Address Ru',
            'address_en' => 'Address En',
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
    public  static  function  getSetting(){
         return Self::find()->where(['status'=>1])->orderBy('id DESC')->asArray()->one();
    }
}
