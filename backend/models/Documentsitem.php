<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "documents_item".
 *
 * @property int $id
 * @property string|null $title_uz
 * @property string|null $title_ru
 * @property string|null $title_en
 * @property string|null $content_uz
 * @property string|null $content_ru
 * @property string|null $content_en
 * @property int $document_id
 * @property string $slug
 * @property int $status
 *
 * @property Documents $document
 */
class DocumentsItem extends \yii\db\ActiveRecord
{
    const STATUS_SHOWED = 1;
    const STATUS_NOTSHOWED = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documents_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_uz', 'content_ru', 'content_en'], 'string'],
            [['document_id', 'slug', 'status'], 'required'],
            [['document_id', 'status'], 'integer'],
            [['title_uz', 'title_ru', 'title_en', 'slug'], 'string', 'max' => 255],
            [['document_id'], 'exist', 'skipOnError' => true, 'targetClass' => Documents::className(), 'targetAttribute' => ['document_id' => 'id']],
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
            'document_id' => 'Document ID',
            'slug' => 'Slug',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Document]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDocument()
    {
        return $this->hasOne(Documents::className(), ['id' => 'document_id']);
    }
    public  static function getstatus()
    {
        return[
            self::STATUS_SHOWED=>"Faol",
            self::STATUS_NOTSHOWED=>"Faol emasl",
        ];
    }
}
