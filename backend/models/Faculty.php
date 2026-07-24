<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "faculty".
 *
 * @property int $id
 * @property string $titlte_uz
 * @property string $title_ru
 * @property string $title_en
 * @property string $content_uz
 * @property string|null $content_ru
 * @property string|null $content_en
 * @property string $img
 * @property string $slug
 * @property int $status
 */
class Faculty extends \yii\db\ActiveRecord
{
    const STATUS_SHOWED = 1;
    const STATUS_NOTSHOWED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faculty';
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
            [['title_uz', 'title_ru', 'title_en', 'content_uz', 'img',  'status'], 'required'],
            [['content_uz', 'content_ru', 'content_en'], 'string'],
            [['status'], 'integer'],
            [['title_uz', 'title_ru', 'title_en', 'img', 'slug'], 'string', 'max' => 255],
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
    public function getDirections()
    {
        return $this->hasMany(Faculty::className(), ['faculty_id' => 'id']);
    }
    public  static function getstatus()
    {
        return[
            self::STATUS_SHOWED=>"Faol",
            self::STATUS_NOTSHOWED=>"Faol emasl",
        ];
    }
    public  static function getFaculty(){
        return Self::find()->where(['status'=>1])->asArray()->asArray()->all();
    }
}
