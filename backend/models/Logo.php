<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "logo".
 *
 * @property int $id
 * @property string|null $title_uz
 * @property string|null $title_ru
 * @property string|null $title_en
 * @property string $content_uz
 * @property string|null $content_ru
 * @property string|null $content_en
 * @property string $img
 * @property int $status
 */
class Logo extends \yii\db\ActiveRecord
{
    const STATUS_SHOWED = 1;
    const STATUS_NOTSHOWED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'logo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['img', 'status'], 'required'],
            [['status'], 'integer'],
            [['title_uz', 'title_ru', 'title_en', 'img','subtitle_uz', 'subtitle_ru', 'subtitle_en'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_uz' => 'Titlte Uz',
            'title_ru' => 'Title Ru',
            'title_en' => 'Title En',
            'subtitle_uz' => 'Subtitle Uz',
            'subtitle_ru' => 'Subtitle Ru',
            'subtitle_en' => 'Subtitle En',
            'img' => 'Img',
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
    public  static  function  getLogo(){
        return Self::find()->where(['status'=>1])->orderBy('id DESC')->asArray()->one();
    }
}
