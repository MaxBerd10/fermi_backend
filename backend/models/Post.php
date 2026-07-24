<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title_uz
 * @property string $title_ru
 * @property string $title_en
 * @property string|null $content_uz
 * @property string|null $content_ru
 * @property string|null $content_en
 * @property int $category_id
 * @property string $slug
 * @property int $status
 *
 * @property Postcategory $category
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const STATUS_SHOWED = 1;
    const STATUS_NOTSHOWED = 0;

    public static function tableName()
    {
        return 'post';
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
            [['title_uz', 'status', 'category_id'], 'required'],
            [['content_uz', 'content_ru', 'content_en'], 'string'],
            [['status', 'seen'], 'integer'],
            [['seen'], 'default', 'value' => 0],
            [['date'], 'safe'],
            ['img', 'string'],
            [['file', 'file_en', 'file_ru'],'string'],
            ['date', 'default', 'value' => new \yii\db\Expression("NOW()")],
            ['who_create', 'default', 'value' => Yii::$app->user->identity->username],
            [['title_uz', 'title_ru', 'title_en', 'who_create', 'slug', 'meta_key'], 'string', 'max' => 255],
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
            'category_id' => 'Category Id',
            'date' => 'date',
            'seen' => 'Seen',
            'slug' => 'Slug',
            'status' => 'Status',
            'who_create' => 'Who create',
            'meta_key' => 'Meta key'

        ];
    }

    /**
     * Gets query for [[Category]].
     *
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Postcategory::className(), ['id' => 'category_id']);
    }

    public static function getstatus()
    {
        return [
            self::STATUS_SHOWED => "Faol",
            self::STATUS_NOTSHOWED => "Faol emasl",
        ];
    }

}
