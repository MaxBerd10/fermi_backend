<?php

namespace api\controllers;

use backend\models\Departments;

class AdminDepartmentsController extends BaseAdminController
{
    protected function modelClass()
    {
        return Departments::class;
    }

    protected function applyFilters($query)
    {
        $query->orderBy(['id' => SORT_DESC]);
    }
}
