<?php

namespace api\controllers;

use backend\models\Contact;

/** Public-submitted contact-form entries — admin can review/mark-status/delete. */
class AdminContactController extends BaseAdminController
{
    protected function modelClass()
    {
        return Contact::class;
    }

    protected function applyFilters($query)
    {
        $query->orderBy(['id' => SORT_DESC]);
    }
}
