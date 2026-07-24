<?php

namespace api\controllers;

use backend\models\Course;

class AdminCourseController extends BaseAdminController
{
    protected function modelClass()
    {
        return Course::class;
    }

    protected function applyFilters($query)
    {
        $query->orderBy(['id' => SORT_DESC]);
    }
}
