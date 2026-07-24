<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "leader".
 *
 * @property int $id
 * @property string $name
 * @property string $position_uz
 * @property string|null $position_en
 * @property string|null $position_ru
 * @property string $activity_uz
 * @property string|null $activity_ru
 * @property string|null $activity_en
 * @property string $biography_uz
 * @property string|null $biography_ru
 * @property string|null $biography_en
 * @property string $reception_days
 * @property string $phone
 * @property string|null $faks
 * @property string $email
 * @property string $rasm
 * @property int $status
 */
class Leader extends \yii\db\ActiveRecord
{
    const STATUS_SHOWED = 1;
    const STATUS_NOTSHOWED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leader';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_uz', 'position_uz',  'phone', 'email', 'rasm', 'status','category_id','reception_days_uz'], 'required'],
            [[ 'biography_uz', 'biography_ru', 'biography_en','activity_en','activity_uz','activity_ru','reception_days_en','reception_days_ru','name_en','name_ru','reception_days_uz'], 'string'],
            [['status'], 'integer'],
            [['name_uz', 'position_uz', 'position_en', 'position_ru',  'phone', 'faks', 'email', 'rasm','reception_days_uz'], 'string', 'max' => 200],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_uz' => 'Name Uz',
            'position_uz' => 'Position Uz',
            'position_en' => 'Position En',
            'position_ru' => 'Position Ru',
            'biography_uz' => 'Biography Uz',
            'biography_ru' => 'Biography Ru',
            'biography_en' => 'Biography En',
            'activity_en'=>'Activity En',
            'activity_uz'=>'Activity Uz',
            'activity_ru'=>'Activity ru',
            'category_id'=>'Category Id',
            'reception_days_uz'=>'Reception Days Uz',
            'reception_days_en'=>'Reception Days EN',
            'reception_days_ru'=>'Reception Days Ru',
            'phone' => 'Phone',
            'name_en'=>'Name_en',
            'name_ru'=>'Name Ru',
            'faks' => 'Faks',
            'email' => 'Email',
            'rasm' => 'Rasm',
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
    public function getCategor()
    {
        return $this->hasOne(Leadercategory::className(), ['id' => 'category_id']);
    }
}
