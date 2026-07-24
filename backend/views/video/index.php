<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VideoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Videos';
$this->params['breadcrumbs'][] = $this->title;
$this->params['create']=Html::a('<span class="glyphicon glyphicon-plus btn btn-success"></span>',['video/create']);

?>
<div class="video-index">



    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class'=>\yii\grid\SerialColumn::class,
                'contentOptions'=>function(\backend\models\Video $model){
                    $class='';
                    switch ($model->status)
                    {
                        case \backend\models\Video ::STATUS_SHOWED:$class='alert-success';break;
                        case \backend\models\Video ::STATUS_NOTSHOWED:$class='alert-danger';break;
                        default:$class='alert-info';
                    }
                    return['class'=>$class];
                }
            ],

            //'id',
           [
               'attribute'=>'video',
               'format'=>'raw',
               'value'=>function($model){
                    return '<video src="' . $model->video . '" style="width: 60%"  height="60%" controls="true"></video>';
               }
               ],
            'url:url',
            [
                'attribute'=>'status',
                'label'=>'status',
                'value'=>function(\backend\models\Video $model)
                {
                    return \backend\models\Video::getstatus()[$model->status];
                },
                'filter'=>\backend\models\Video::getstatus(),
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
