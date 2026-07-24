<?php

namespace api\controllers;

use backend\models\About;

class AdminAboutController extends BaseAdminController
{
    protected function modelClass()
    {
        return About::class;
    }

    protected function applyFilters($query)
    {
        $query->orderBy(['id' => SORT_DESC]);
    }
}
