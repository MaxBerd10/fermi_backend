<?php

namespace api\controllers;

use backend\models\Logo;

/** Singleton table (1 row) — React admin uses only view/update, no list/create/delete UI. */
class AdminLogoController extends BaseAdminController
{
    protected function modelClass()
    {
        return Logo::class;
    }
}
