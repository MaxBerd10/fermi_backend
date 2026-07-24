<?php

namespace api\controllers;

use Yii;
use backend\models\Schedule;

class AdminScheduleController extends BaseAdminController
{
    protected function modelClass()
    {
        return Schedule::class;
    }

    protected function applyFilters($query)
    {
        $courseId = Yii::$app->request->get('courseId');
        if ($courseId) {
            $query->andWhere(['course_id' => $courseId]);
        }
        $query->orderBy(['id' => SORT_DESC]);
    }
}
