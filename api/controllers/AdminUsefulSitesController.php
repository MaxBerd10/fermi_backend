<?php

namespace api\controllers;

use backend\models\UsefulSites;

class AdminUsefulSitesController extends BaseAdminController
{
    protected function modelClass()
    {
        return UsefulSites::class;
    }

    protected function applyFilters($query)
    {
        $query->orderBy(['id' => SORT_DESC]);
    }
}
