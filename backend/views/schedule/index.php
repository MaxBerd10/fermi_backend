<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ScheduleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Dars jadvali');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-index">

    <?$this->params['create']=Html::a('<span class="glyphicon glyphicon-plus btn btn-success"></span>',['schedule/create']);?>


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class'=>\yii\grid\SerialColumn::class,
                'contentOptions'=>function(\backend\models\Schedule $model){
                    $class='';
                    switch ($model->status)
                    {
                        case \backend\models\Schedule::STATUS_SHOWED:$class='alert-success';break;
                        case \backend\models\Schedule::STATUS_NOTSHOWED:$class='alert-danger';break;
                        default:$class='alert-info';
                    }
                    return['class'=>$class];
                }
            ],

           // 'id',
            'title_uz',
            //'title_ru',
           // 'title_en',
           // 'course_id',

            [
                    'attribute'=>'course_id',
                    'value'=>function(\backend\models\Schedule $model){
                         return $model->course->title_uz;
                    }
            ],
            //'file',
            //'status',

            [
                'attribute'=>'status',
                'label'=>'status',
                'value'=>function(\backend\models\Schedule $model){
                    return \backend\models\Schedule::getstatus()[$model->status];
                },
                'filter'=>\backend\models\Schedule::getstatus(),
            ],
            ['class' => 'yii\grid\ActionColumn','template'=>'{view} {update} {delete} {mark}',
                'buttons'=>[
                    'mark'=>function($url,$model,$key)
                    {
                        if ($model->status==1){
                            return Html::a('<span class="glyphicon glyphicon-ok btn btn-success"></span>',$url);
                        }
                        else
                        {
                            return Html::a('<span class="glyphicon glyphicon-ok btn btn-danger"></span>',$url);
                        }
                    },
                    'view'=>function($url,$model,$key){
                        return Html::a('<span class="glyphicon glyphicon-eye-open btn btn-info"></span>',$url);
                    },
                    'update'=>function($url,$model,$key){
                        return Html::a('<span class="glyphicon glyphicon-pencil btn btn-warning"></span>',$url);
                    },
                    'delete'=>function($url,$model,$key){
                        return Html::a('<span class="glyphicon glyphicon-trash btn btn-danger"></span>',$url, ['data-method'=>"POST"]);
                    }
                ],


            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
