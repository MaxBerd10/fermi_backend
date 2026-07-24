<?php

namespace api\controllers;

use backend\models\Virtual;

/** Public-submitted "virtual qabulxona" form entries — admin can review/delete. */
class AdminVirtualController extends BaseAdminController
{
    protected function modelClass()
    {
        return Virtual::class;
    }

    protected function applyFilters($query)
    {
        $query->orderBy(['id' => SORT_DESC]);
    }
}
