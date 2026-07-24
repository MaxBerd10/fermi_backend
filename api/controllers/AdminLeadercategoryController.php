<?php

namespace api\controllers;

use backend\models\Leadercategory;

class AdminLeadercategoryController extends BaseAdminController
{
    protected function modelClass()
    {
        return Leadercategory::class;
    }

    protected function applyFilters($query)
    {
        $query->orderBy(['id' => SORT_DESC]);
    }
}
