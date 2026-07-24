<?php

namespace api\controllers;

use backend\models\Faculty;

class AdminFacultyController extends BaseAdminController
{
    protected function modelClass()
    {
        return Faculty::class;
    }

    protected function applyFilters($query)
    {
        $query->orderBy(['id' => SORT_DESC]);
    }
}
