<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "corusel".
 *
 * @property int $id
 * @property string $titlte_uz
 * @property string|null $title_ru
 * @property string|null $title_en
 * @property string $content_uz
 * @property string|null $content_ru
 * @property string|null $content_en
 * @property string $slug
 * @property int $status
 */
class Corusel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const STATUS_SHOWED=1;
    const STATUS_NOTSHOWED=0;
    public static function tableName()
    {
        return 'corusel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['status'], 'integer'],
            [['title_uz', 'title_ru', 'title_en','img'], 'string', 'max' => 200],
            [['content_uz', 'content_ru', 'content_en'], 'string'],

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
            'content_uz' => 'Content Uz',
            'content_ru' => 'Content Ru',
            'Content_en' => 'Content En',
            'img'=>'Img',
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
    public  static function getCorusel(){
        return Self::find()->where(['status'=>1])->orderBy('id DESC')->limit(8)->asArray()->all();
    }
}
