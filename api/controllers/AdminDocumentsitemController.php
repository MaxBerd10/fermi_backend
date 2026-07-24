<?php

namespace api\controllers;

use Yii;
use backend\models\Documentsitem;

class AdminDocumentsitemController extends BaseAdminController
{
    protected function modelClass()
    {
        return Documentsitem::class;
    }

    protected function applyFilters($query)
    {
        $documentId = Yii::$app->request->get('documentId');
        if ($documentId) {
            $query->andWhere(['document_id' => $documentId]);
        }
        $query->orderBy(['id' => SORT_DESC]);
    }
}
