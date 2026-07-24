<?php

namespace api\controllers;

use backend\models\Postcategory;

/**
 * /v1/admin/postcategories CRUD — used both as its own admin screen and as
 * the category dropdown source for the "Yangiliklar" (Post) admin form.
 */
class AdminPostcategoryController extends BaseAdminController
{
    protected function modelClass()
    {
        return Postcategory::class;
    }

    protected function applyFilters($query)
    {
        $query->orderBy(['id' => SORT_DESC]);
    }
}
