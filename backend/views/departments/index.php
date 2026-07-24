<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DepartmentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kafedralar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="departments-index">

    <p>
        <? $this->params['create']=Html::a('<span class="glyphicon glyphicon-plus btn btn-success" ></span>',['departments/create'],['style'=>'margin-right:10px']) ?>
    </p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class'=>\yii\grid\SerialColumn::class,
                'contentOptions'=>function(\backend\models\Departments $model){
                    $class='';
                    switch ($model->status)
                    {
                        case \backend\models\Departments::STATUS_SHOWED:$class='alert-success';break;
                        case \backend\models\Departments::STATUS_NOTSHOWED:$class='alert-danger';break;
                        default:$class='alert-info';
                    }
                    return['class'=>$class];
                }
            ],
            'title_uz',
            'title_ru',
            'title_en',
            [
                'attribute'=>'content_uz',
                'label'=>'content_uz',
                'format'=>'html',
                'value'=>function(\backend\models\Departments $model){
                    return mb_substr(strip_tags($model->content_uz),0,200);
                }
            ],
            [
                'attribute' => 'img',
                'label' => 'img',
                'format' => 'html',
                'value' => function(\backend\models\Departments $model)
                {
                    return Html::img($model->img,['style'=>'width:80px; height:auto']);
                }
            ],
            //'content_ru:ntext',
            //'content_en:ntext',
            //'slug',
            //'status',

            [
                'attribute'=>'status',
                'label'=>'status',
                'value'=>function(\backend\models\Departments $model){
                    return \backend\models\Departments::getstatus()[$model->status];
                },
                'filter'=>\backend\models\Departments::getstatus(),
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
