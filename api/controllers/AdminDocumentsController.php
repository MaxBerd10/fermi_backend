<?php

namespace api\controllers;

use backend\models\Documents;

class AdminDocumentsController extends BaseAdminController
{
    protected function modelClass()
    {
        return Documents::class;
    }

    protected function applyFilters($query)
    {
        $query->orderBy(['id' => SORT_DESC]);
    }
}
