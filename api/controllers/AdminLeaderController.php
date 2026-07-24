<?php

namespace api\controllers;

use Yii;
use backend\models\Leader;

class AdminLeaderController extends BaseAdminController
{
    protected function modelClass()
    {
        return Leader::class;
    }

    protected function applyFilters($query)
    {
        $categoryId = Yii::$app->request->get('categoryId');
        if ($categoryId) {
            $query->andWhere(['category_id' => $categoryId]);
        }
        $query->orderBy(['id' => SORT_DESC]);
    }
}
