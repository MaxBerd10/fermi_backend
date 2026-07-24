<?php

namespace api\controllers;

use backend\models\Acceptance;

/** Public-submitted "qabul" (admission) form entries — admin can review/delete. */
class AdminAcceptanceController extends BaseAdminController
{
    protected function modelClass()
    {
        return Acceptance::class;
    }

    protected function applyFilters($query)
    {
        $query->orderBy(['id' => SORT_DESC]);
    }
}
