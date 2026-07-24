<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "districts".
 *
 * @property int $id
 * @property int $region_id
 * @property string|null $name
 *
 * @property Virtual[] $virtuals
 */
class Districts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'districts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id'], 'required'],
            [['region_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region_id' => 'Region ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Virtuals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVirtuals()
    {
        return $this->hasMany(Virtual::className(), ['fog' => 'id']);
    }
}
