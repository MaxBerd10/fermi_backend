<?php

namespace api\controllers;

use backend\models\Counter;

/** Singleton table (1 row) — React admin uses only view/update, no list/create/delete UI. */
class AdminCounterController extends BaseAdminController
{
    protected function modelClass()
    {
        return Counter::class;
    }
}
