<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "virtual".
 *
 * @property int $id
 * @property string $fish
 * @property int $province
 * @property int $fog
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property string $gender
 * @property int $faculty_id
 * @property string $text
 * @property string $file
 * @property int $status
 *
 * @property Faculty $faculty
 * @property Regions $province0
 * @property Districts $fog0
 */
class Virtual extends \yii\db\ActiveRecord
{
    const STATUS_SHOWED = 1;
    const STATUS_NOTSHOWED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'virtual';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fish', 'province', 'fog', 'address', 'phone', 'email', 'gender', 'faculty_id', 'text',], 'required'],
            [['province', 'fog', 'faculty_id', 'status', 'created_at'], 'integer'],
            [['text'], 'string'],
            [['file'], 'file', 'extensions' => ['pdf', 'docx', 'png', 'jpg', 'xslx', 'svg', 'pptx']],
            ['phone', 'match', 'pattern' => '/\+[9][9][8] [389][013789] [0-9][0-9][0-9] [0-9][0-9] [0-9][0-9]/'],
            [['fish', 'address', 'phone', 'email', 'gender'], 'string', 'max' => 200],
            [['faculty_id'], 'exist', 'skipOnError' => true, 'targetClass' => Faculty::className(), 'targetAttribute' => ['faculty_id' => 'id']],
            [['province'], 'exist', 'skipOnError' => true, 'targetClass' => Regions::className(), 'targetAttribute' => ['province' => 'id']],
            [['fog'], 'exist', 'skipOnError' => true, 'targetClass' => Districts::className(), 'targetAttribute' => ['fog' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fish' => 'Fish',
            'province' => 'Province',
            'fog' => 'Fog',
            'address' => 'Address',
            'phone' => 'Phone',
            'email' => 'Email',
            'gender' => 'Gender',
            'faculty_id' => 'Faculty ID',
            'text' => 'Text',
            'file' => 'File',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Faculty]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaculty()
    {
        return $this->hasOne(Faculty::className(), ['id' => 'faculty_id']);
    }

    /**
     * Gets query for [[Province0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvince0()
    {
        return $this->hasOne(Regions::className(), ['id' => 'province']);
    }

    /**
     * Gets query for [[Fog0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFog0()
    {
        return $this->hasOne(Districts::className(), ['id' => 'fog']);
    }

    public static function getstatus()
    {
        return
            [
                self::STATUS_SHOWED => "Faol",
                self::STATUS_NOTSHOWED => "Faol emasl",
            ];
    }
}
