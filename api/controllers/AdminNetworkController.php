<?php

namespace api\controllers;

use backend\models\Network;

class AdminNetworkController extends BaseAdminController
{
    protected function modelClass()
    {
        return Network::class;
    }

    protected function applyFilters($query)
    {
        $query->orderBy(['id' => SORT_DESC]);
    }
}
