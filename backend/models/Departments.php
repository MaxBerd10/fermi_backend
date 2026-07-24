<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "departments".
 *
 * @property int $id
 * @property string $title_uz
 * @property string|null $title_ru
 * @property string|null $title_en
 * @property string $content_uz
 * @property string|null $content_ru
 * @property string|null $content_en
 * @property string|null $slug
 * @property int $status
 */
class Departments extends \yii\db\ActiveRecord
{
    const STATUS_SHOWED = 1;
    const STATUS_NOTSHOWED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'departments';
    }

    /**
     * {@inheritdoc}
     */
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
            [['title_uz', 'content_uz','img', 'status'], 'required'],
            [['content_uz', 'content_ru', 'content_en'], 'string'],
            [['status'], 'integer'],
            [['title_uz', 'title_ru', 'title_en', 'slug','img'], 'string', 'max' => 200],
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
            'img'=>'Img',
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
    public  static function  getDepartmenst()
    {
        return self::find()->where(['status'=>1])->asArray()->all();
    }
}
