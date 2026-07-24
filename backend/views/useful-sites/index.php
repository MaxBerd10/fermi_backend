<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UsefulSitesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Useful Sites';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="useful-sites-index">

    <?$this->params['create']=Html::a('<span class="glyphicon glyphicon-plus btn btn-success"></span>',['useful-sites/create']);
    ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class'=>\yii\grid\SerialColumn::class,
                'contentOptions'=>function(\backend\models\UsefulSites $model){
                    $class='';
                    switch ($model->status)
                    {
                        case \backend\models\UsefulSites::STATUS_SHOWED:$class='alert-success';break;
                        case \backend\models\UsefulSites::STATUS_NOTSHOWED:$class='alert-danger';break;
                        default:$class='alert-info';
                    }
                    return['class'=>$class];
                }
            ],
            'title_uz',

            //'title_ru',
            //'title_en',
            [
                'attribute' => 'img',
                'label' => 'img',
                'format' => 'html',
                'value' => function(\backend\models\UsefulSites $model)
                {
                    return Html::img($model->img,['style'=>'width:120px; height:auto']);
                }
            ],
            //'status',
            [
                'attribute'=>'status',
                'label'=>'status',
                'value'=>function(\backend\models\UsefulSites $model){
                    return \backend\models\UsefulSites::getstatus()[$model->status];
                },
                'filter'=>\backend\models\UsefulSites::getstatus(),
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
