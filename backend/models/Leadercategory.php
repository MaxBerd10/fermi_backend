<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "leadercategory".
 *
 * @property int $id
 * @property string $title_uz
 * @property string $title_ru
 * @property string $title_en
 * @property string $slug
 * @property int $status
 */
class Leadercategory extends \yii\db\ActiveRecord
{
    const STATUS_SHOWED = 1;
    const STATUS_NOTSHOWED = 0;

    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'leadercategory';
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
            [['status','is_faculty'], 'integer'],
            [['title_uz', 'title_ru', 'title_en', 'slug'], 'string', 'max' => 200],
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
            'is_faculty'=>'Is Faculty'
        ];
    }
    public  static function getstatus()
    {
        return[
            self::STATUS_SHOWED=>"Faol",
            self::STATUS_NOTSHOWED=>"Faol emasl",
        ];
    }
    public  static function getLeadercategory()
    {
        return self::find()->where(['status'=>1])->asArray()->all();
    }
    public function getleaders()
    {
        return $this->hasMany(Leader::className(), ['category_id' => 'id']);
    }
}
