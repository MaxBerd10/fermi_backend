<?php

namespace api\controllers;

use backend\models\Setting;

/** Singleton table (1 row) — React admin uses only view/update, no list/create/delete UI. */
class AdminSettingController extends BaseAdminController
{
    protected function modelClass()
    {
        return Setting::class;
    }
}
