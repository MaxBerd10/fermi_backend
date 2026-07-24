<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property int $id
 * @property string $name
 * @property string $subject
 * @property string $phone
 * @property string $email
 * @property string $message
 * @property int $status
 */
class Contact extends \yii\db\ActiveRecord
{
    const STATUS_SHOWED = 1;
    const STATUS_NOTSHOWED =0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'subject', 'phone', 'email', 'message',], 'required'],
            [['message'], 'string'],
            [['status'], 'integer'],
            [['status'], 'default', 'value'=>0],
            ['email', 'email','message' => 'email kiriting'],
            [['name', 'subject'], 'string', 'max' => 200],
            [['phone'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t("app","name"),
            'subject' => Yii::t("app","Subject"),
            'phone' => Yii::t("app","Telefon"),
            'email' => Yii::t("app","Elektron pochta"),
            'message' => Yii::t("app","Message"),
            'status' => 'Status',
        ];
    }
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['rector'] = ['name',  'email','message'];
        $scenarios['contact-form']=['name', 'subject', 'phone', 'email', 'message',];
        return $scenarios;
    }
    public  static function getstatus()
    {
        return[
            self::STATUS_SHOWED=>"Faol",
            self::STATUS_NOTSHOWED=>"Faol emasl",
        ];
    }

}
