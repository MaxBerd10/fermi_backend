<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "counter".
 *
 * @property int $id
 * @property int $professor_teachers
 * @property int $students
 * @property int $graduaters
 * @property int $book_fund
 * @property int $status
 */
class Counter extends \yii\db\ActiveRecord
{
    const STATUS_SHOWED = 1;
    const STATUS_NOTSHOWED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'counter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['professor_teachers', 'students', 'graduaters', 'book_fund', 'status'], 'required'],
            [['professor_teachers', 'students', 'graduaters', 'book_fund', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'professor_teachers' => 'Professor Teachers',
            'students' => 'Students',
            'graduaters' => 'Graduaters',
            'book_fund' => 'Book Fund',
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
    public  static function getCounter(){
        return Self::find()->where(['status'=>1])->asArray()->asArray()->one();
    }
}
