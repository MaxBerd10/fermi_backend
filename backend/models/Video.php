<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "video".
 *
 * @property int $id
 * @property string|null $video
 * @property string|null $url
 * @property int $status
 */
class Video extends \yii\db\ActiveRecord
{
    const STATUS_SHOWED = 1;
    const STATUS_NOTSHOWED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['status'], 'integer'],
            [['video', 'url'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'video' => 'Video',
            'url' => 'Url',
            'status' => 'Status',
        ];
    }
    public  static function getstatus()
    {
        return
            [
            self::STATUS_SHOWED=>"Faol",
            self::STATUS_NOTSHOWED=>"Faol emasl",
        ];
    }
    public  static function getVideo()
    {
        return Self::find()->where(['status'=>1])->orderBy('id DESC')->limit(8)->asArray()->all();
    }

}
