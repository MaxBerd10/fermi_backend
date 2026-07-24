<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "img".
 *
 * @property int $id
 * @property string $title_uz
 * @property string $title_ru
 * @property string $title_en
 * @property string|null $content_uz
 * @property string|null $content_ru
 * @property string|null $content_en
 * @property string $img
 * @property string $img_type
 * @property string|null $slug
 * @property int $status
 */
class Img extends \yii\db\ActiveRecord
{
    const STATUS_SHOWED = 1;
    const STATUS_NOTSHOWED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'img';
    }
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = [
            'class' => \common\components\CyrillicSlugBehavior::className(),
            'attribute' => 'title_uz',
        ];
        return $behaviors;
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'img','status'], 'required'],
            [['content_uz', 'content_ru', 'content_en'], 'string'],
            [['status'], 'integer'],
            [['title_uz', 'title_ru', 'title_en', 'img','slug'], 'string', 'max' => 200],
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
    
public  static  function getImg()
{
    return self::find()->where(['status'=>1])->orderBy('id DESC')->limit(20)->asArray()->all();
}

}
