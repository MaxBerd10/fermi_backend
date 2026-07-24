<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CounterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Faktlar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="counter-index">

    <?
    $this->params['create']=Html::a('<span class="glyphicon glyphicon-plus btn btn-success"></span>',['counter/create']);
    ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class'=>\yii\grid\SerialColumn::class,
                'contentOptions'=>function(\backend\models\Counter $model){
                    $class='';
                    switch ($model->status)
                    {
                        case \backend\models\Counter::STATUS_SHOWED:$class='alert-success';break;
                        case \backend\models\Counter::STATUS_NOTSHOWED:$class='alert-danger';break;
                        default:$class='alert-info';
                    }
                    return['class'=>$class];
                }
            ],
            'professor_teachers',
            'students',
            'graduaters',
            'book_fund',
            //'status',

            [
                'attribute'=>'status',
                'label'=>'status',
                'value'=>function(\backend\models\Counter $model){
                    return \backend\models\Counter::getstatus()[$model->status];
                },
                'filter'=>\backend\models\Counter::getstatus(),
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
