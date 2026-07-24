<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property string $title_uz
 * @property string|null $title_ru
 * @property string|null $title_en
 * @property string $content_uz
 * @property string|null $content_ru
 * @property string|null $content_en
 * @property string $slug
 * @property string|null $date
 * @property int $status
 * @property int|null $korish
 * @property string|null $meta_key
 */

class Page extends \yii\db\ActiveRecord
{
    const STATUS_SHOWED=1;
    const STATUS_NOTSHOWED=0;
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
 
    public static function tableName()
    {
        return 'page';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title_uz',  'status'], 'required'],
            [['content_uz', 'content_ru', 'content_en'], 'string'],
            [['date'], 'safe'],
            [['korish'], 'default', 'value'=>0],
            [['status', 'korish'], 'integer'],
            [['title_uz', 'title_ru', 'title_en', 'slug', 'meta_key','file','file_en','file_ru'], 'string', 'max' => 255],
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
            'slug' => 'Slug',
            'date' => 'Date',
            'status' => 'Status',
            'korish' => 'Korish',
            'meta_key' => 'Meta Key',
            'file'=>'file',
             'file_en'=>'file en',
              'file_ru'=>'file ru',
        ];
    }
    public  static function getstatus()
    {
        return[
            self::STATUS_SHOWED=>"Faol",
            self::STATUS_NOTSHOWED=>"Faol emas",
        ];
    }
}
