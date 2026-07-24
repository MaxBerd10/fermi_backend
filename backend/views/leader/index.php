<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LeaderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leaders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leader-index">

    <p>
        <? $this->params['create']=Html::a('<span class="glyphicon glyphicon-plus btn btn-success" ></span>',['leader/create'],['style'=>'margin-right:10px']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class'=>\yii\grid\SerialColumn::class,
                'contentOptions'=>function(\backend\models\Leader $model){
                    $class='';
                    switch ($model->status)
                    {
                        case \backend\models\Leader ::STATUS_SHOWED:$class='alert-success';break;
                        case \backend\models\Leader ::STATUS_NOTSHOWED:$class='alert-danger';break;
                        default:$class='alert-info';
                    }
                    return['class'=>$class];
                }
            ],

            //'id',
            'name_uz',
            'position_uz',
           // 'activity_uz',
            //'position_en',
            //'position_ru',


            //'biography_uz:ntext',
            //'biography_ru:ntext',
            [
                    'attribute' => 'biography_uz',
                'label' => 'biography_uz',
                'format' => 'html',
                'value' => function(\backend\models\Leader $model){
                     return mb_substr(strip_tags($model->biography_uz),0,150);
                }
            ],
            [
                'attribute' => 'activity_uz',
                'label' => 'activity_uz',
                'format' => 'html',
                'value' => function(\backend\models\Leader $model){
                    return mb_substr(strip_tags($model->activity_uz),0,150);
                }
            ],
            //'biography_en:ntext',
            //'phone',
            //'faks',
            //'email:email',
            //'rasm',
            [
                    'attribute' => 'rasm',
                'label' => 'rasm',
                'format' => 'html',
                'value' => function(\backend\models\Leader $model){
                            return Html::img($model->rasm,['style'=>'width:120px;height:auto']);
                }
            ],
            [
                'attribute'=>'status',
                'label'=>'status',
                'value'=>function(\backend\models\Leader $model){
                    return \backend\models\Leader::getstatus()[$model->status];
                },
                'filter'=>\backend\models\Leader::getstatus(),
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


</div>
