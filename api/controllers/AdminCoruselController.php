<?php

namespace api\controllers;

use backend\models\Corusel;

class AdminCoruselController extends BaseAdminController
{
    protected function modelClass()
    {
        return Corusel::class;
    }

    protected function applyFilters($query)
    {
        $query->orderBy(['id' => SORT_DESC]);
    }
}
