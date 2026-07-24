<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "schedule".
 *
 * @property int $id
 * @property string $title_uz
 * @property string|null $title_ru
 * @property string|null $title_en
 * @property int $course_id
 * @property string $file
 * @property int $status
 *
 * @property Course $course
 */
class Schedule extends \yii\db\ActiveRecord
{
    const STATUS_SHOWED = 1;
    const STATUS_NOTSHOWED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'schedule';
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
            [['title_uz', 'course_id', 'file', 'status'], 'required'],
            [['course_id', 'status'], 'integer'],
            [['title_uz', 'title_ru', 'title_en', 'file'], 'string', 'max' => 255],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
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
            'course_id' => 'Course ID',
            'file' => 'File',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Course]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }
}
