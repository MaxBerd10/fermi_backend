<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Kurs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-index">

    <?$this->params['create']=Html::a('<span class="glyphicon glyphicon-plus btn btn-success"></span>',['course/create']);?>


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class'=>\yii\grid\SerialColumn::class,
                'contentOptions'=>function(\backend\models\Course $model){
                    $class='';
                    switch ($model->status)
                    {
                        case \backend\models\Course::STATUS_SHOWED:$class='alert-success';break;
                        case \backend\models\Course::STATUS_NOTSHOWED:$class='alert-danger';break;
                        default:$class='alert-info';
                    }
                    return['class'=>$class];
                }
            ],
           // 'id',
            'title_uz',
           // 'title_ru',
            //'title_en',

            [
                'attribute'=>'status',
                'label'=>'status',
                'value'=>function(\backend\models\Course $model){
                    return \backend\models\Course::getstatus()[$model->status];
                },
                'filter'=>\backend\models\Course::getstatus(),
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
            ]
    ]); ?>

    <?php Pjax::end(); ?>

</div>
