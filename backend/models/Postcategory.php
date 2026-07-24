<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "postcategory".
 *
 * @property int $id
 * @property string $title_uz
 * @property string $title_ru
 * @property string $title_en
 * @property string $slug
 * @property int $status
 *
 * @property Post[] $posts
 */
class Postcategory extends \yii\db\ActiveRecord
{
    const STATUS_SHOWED = 1;
    const STATUS_NOTSHOWED = 0;

    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'postcategory';
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
            [['title_uz', 'title_ru', 'title_en', 'status'], 'required'],
            [['status'], 'integer'],
            [['title_uz', 'title_ru', 'title_en', 'slug'], 'string', 'max' => 255],
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
            'slug' => 'Slug',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['category_id' => 'id']);
    }
    public  static function getstatus()
    {
        return[
            self::STATUS_SHOWED=>"Faol",
            self::STATUS_NOTSHOWED=>"Faol emasl",
        ];
    }
}
