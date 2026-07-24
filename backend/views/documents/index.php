<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DocumentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hujjatlar';
$this->params['breadcrumbs'][] = $this->title;
$this->params['create']=Html::a('<span class="glyphicon glyphicon-plus btn btn-success"></span>',['documents/create']);

?>
<div class="documents-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class'=>\yii\grid\SerialColumn::class,
                'contentOptions'=>function(\backend\models\Documents $model){
                    $class='';
                    switch ($model->status)
                    {
                        case \backend\models\Documents::STATUS_SHOWED:$class='alert-success';break;
                        case \backend\models\Documents::STATUS_NOTSHOWED:$class='alert-danger';break;
                        default:$class='alert-info';
                    }
                    return['class'=>$class];
                }
            ],
            'title_uz',
            //'title_ru',
           // 'title_en',
            [
                'attribute'=>'status',
                'label'=>'status',
                'value'=>function(\backend\models\Documents $model){
                    return \backend\models\Documents::getstatus()[$model->status];
                },
                'filter'=>\backend\models\Documents::getstatus(),
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
            //'status',

        ],
    ]); ?>


</div>
