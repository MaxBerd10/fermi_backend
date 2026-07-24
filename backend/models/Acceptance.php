<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "acceptance".
 *
 * @property int $id
 * @property int $category_id
 * @property string $date
 * @property string $subject
 * @property string $fish
 * @property string $phone
 * @property string $email
 * @property int $region_id
 * @property int $district_id
 * @property int $quater_id
 *
 * @property Leadercategory $category
 * @property Quarters $quater
 * @property Districts $district
 * @property Regions $region
 */
class Acceptance extends \yii\db\ActiveRecord
{
    const STATUS_SHOWED = 1;
    const STATUS_NOTSHOWED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acceptance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'date', 'subject', 'fish', 'phone', 'email', 'region_id', 'district_id', 'quater_id'], 'required'],
            [['category_id', 'region_id', 'district_id', 'quater_id','status'], 'integer'],
            [['date'], 'safe'],
            ['phone', 'match', 'pattern' => '/\+[9][9][8] [389][013789] [0-9][0-9][0-9] [0-9][0-9] [0-9][0-9]/'],
            [['subject', 'fish', 'phone', 'email'], 'string', 'max' => 200],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Leadercategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['quater_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quarters::className(), 'targetAttribute' => ['quater_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => Districts::className(), 'targetAttribute' => ['district_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Regions::className(), 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'date' => 'Date',
            'subject' => 'Subject',
            'fish' => 'Fish',
            'phone' => 'Phone',
            'email' => 'Email',
            'status'=>'status',
            'region_id' => 'Region ID',
            'district_id' => 'District ID',
            'quater_id' => 'Quater ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ConnectLeader::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Quater]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuater()
    {
        return $this->hasOne(Quarters::className(), ['id' => 'quater_id']);
    }

    /**
     * Gets query for [[District]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(Districts::className(), ['id' => 'district_id']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Regions::className(), ['id' => 'region_id']);
    }
    public function getProvince()
    {
        return $this->hasOne(Regions::className(), ['id' => 'region_id']);
    }
    public  static function getstatus()
    {
        return[
            self::STATUS_SHOWED=>"Faol",
            self::STATUS_NOTSHOWED=>"Faol emasl",
        ];
    }
}
