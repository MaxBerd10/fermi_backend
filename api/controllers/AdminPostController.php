<?php

namespace api\controllers;

use Yii;
use backend\models\Post;

/**
 * /v1/admin/news CRUD — backs the React admin's "Yangiliklar" screen.
 */
class AdminPostController extends BaseAdminController
{
    protected function modelClass()
    {
        return Post::class;
    }

    protected function applyFilters($query)
    {
        $search = Yii::$app->request->get('search');
        if ($search) {
            $query->andWhere(['like', 'title_uz', $search]);
        }
        $categoryId = Yii::$app->request->get('categoryId');
        if ($categoryId) {
            $query->andWhere(['category_id' => $categoryId]);
        }
        $query->orderBy(['id' => SORT_DESC]);
    }
}
