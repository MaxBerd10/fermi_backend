<?php

namespace api\controllers;

use backend\models\Img;

class AdminImgController extends BaseAdminController
{
    protected function modelClass()
    {
        return Img::class;
    }

    protected function applyFilters($query)
    {
        $query->orderBy(['id' => SORT_DESC]);
    }
}
