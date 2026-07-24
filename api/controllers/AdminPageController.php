<?php

namespace api\controllers;

use Yii;
use backend\models\Page;

/**
 * /v1/admin/pages CRUD — backs the React admin's "Sahifalar" screen.
 */
class AdminPageController extends BaseAdminController
{
    protected function modelClass()
    {
        return Page::class;
    }

    protected function applyFilters($query)
    {
        $search = Yii::$app->request->get('search');
        if ($search) {
            $query->andWhere(['like', 'title_uz', $search]);
        }
        $query->orderBy(['id' => SORT_DESC]);
    }
}
