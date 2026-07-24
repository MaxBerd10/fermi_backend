<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "about".
 *
 * @property int $id
 * @property string $title_uz
 * @property string $title_ru
 * @property string $title_en
 * @property string $content_uz
 * @property string $content_ru
 * @property string $content_en
 * @property string $url
 * @property string $img
 * @property string $slug
 * @property int $status
 */
class About extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'about';
    }

    /**
     * {@inheritdoc}
     */
    const STATUS_SHOWED = 1;
    const STATUS_NOTSHOWED =0;
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = [
            'class' => \common\components\CyrillicSlugBehavior::className(),
            'attribute' => 'title_uz',
        ];
        return $behaviors;
    }
    public function rules()
    {
        return [
            [['title_uz', 'title_ru', 'title_en', 'content_uz', 'url', 'img', 'status'], 'required'],
            [['content_uz', 'content_ru', 'content_en'], 'string'],
            [['status'], 'integer'],
            [['title_uz', 'title_ru', 'title_en', 'url', 'img', 'slug'], 'string', 'max' => 200],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_uz' => 'Title Uz',
            'title_ru' => 'Title Ru',
            'title_en' => 'Title En',
            'content_uz' => 'Content Uz',
            'content_ru' => 'Content Ru',
            'content_en' => 'Content En',
            'url' => 'Url',
            'img' => 'Img',
            'slug' => 'Slug',
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
    public  static function getAbout(){
        return self::find()->where(['status'=>1])->asArray()->one();
    }
}
