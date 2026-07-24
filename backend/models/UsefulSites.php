<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "useful_sites".
 *
 * @property int $id
 * @property string $titlte_uz
 * @property string $title_ru
 * @property string $title_en
 * @property string $img
 * @property int $status
 */
class UsefulSites extends \yii\db\ActiveRecord
{
    const STATUS_SHOWED = 1;
    const STATUS_NOTSHOWED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'useful_sites';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title_uz', 'title_ru', 'title_en', 'img', 'status','url'], 'required'],
            [['status'], 'integer'],
            [['title_uz', 'title_ru', 'title_en', 'img','url'], 'string', 'max' => 255],
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
            'url'=>'Url',
            'img' => 'Img',
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

}
