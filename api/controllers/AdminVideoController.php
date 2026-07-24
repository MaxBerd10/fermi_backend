<?php

namespace api\controllers;

use backend\models\Video;

class AdminVideoController extends BaseAdminController
{
    protected function modelClass()
    {
        return Video::class;
    }

    protected function applyFilters($query)
    {
        $query->orderBy(['id' => SORT_DESC]);
    }
}
