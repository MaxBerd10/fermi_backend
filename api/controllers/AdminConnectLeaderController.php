<?php

namespace api\controllers;

use backend\models\ConnectLeader;

class AdminConnectLeaderController extends BaseAdminController
{
    protected function modelClass()
    {
        return ConnectLeader::class;
    }

    protected function applyFilters($query)
    {
        $query->orderBy(['id' => SORT_DESC]);
    }
}
