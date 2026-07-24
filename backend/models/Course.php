<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "course".
 *
 * @property int $id
 * @property string $title_uz
 * @property string|null $title_ru
 * @property string|null $title_en
 * @property int $status
 *
 * @property Schedule[] $schedules
 */
class Course extends \yii\db\ActiveRecord
{
    const STATUS_SHOWED = 1;
    const STATUS_NOTSHOWED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'course';
    }

    public static function getstatus()
    {
        return[
            self::STATUS_SHOWED=>"Faol",
            self::STATUS_NOTSHOWED=>"Faol emasl",
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title_uz', 'status'], 'required'],
            [['status'], 'integer'],
            [['title_uz', 'title_ru', 'title_en'], 'string', 'max' => 255],
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
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Schedules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSchedules()
    {
        return $this->hasMany(Schedule::className(), ['course_id' => 'id']);
    }
}
