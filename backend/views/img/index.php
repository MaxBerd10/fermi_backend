<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ImgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Imgs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="img-index">

    <p>
        <? $this->params['create']=Html::a('<span class="glyphicon glyphicon-plus btn btn-success" ></span>',['img/create'],['style'=>'margin-right:10px']) ?>
    </p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class'=>\yii\grid\SerialColumn::class,
                'contentOptions'=>function(\backend\models\Img $model){
                    $class='';
                    switch ($model->status)
                    {
                        case \backend\models\Img::STATUS_SHOWED:$class='alert-success';break;
                        case \backend\models\Img::STATUS_NOTSHOWED:$class='alert-danger';break;
                        default:$class='alert-info';
                    }
                    return['class'=>$class];
                }
            ],


            // 'id',
            'title_uz',
            //'title_ru',
           // 'title_en',
           // 'content_uz:ntext',
            [
                    'attribute' => 'content_uz',
                     'label' => 'content_uz',
                     'format' => 'html',
                      'value' => function(\backend\models\Img $model)
                      {
                               return mb_substr(strip_tags($model->content_uz),0,180);
                      }
            ],
            //'content_ru:ntext',
            //'content_en:ntext',
            //'img',
            [
                    'attribute' => 'img',
                     'label' => 'img',
                      'format' => 'html',
                      'value' => function(\backend\models\Img  $model){
                           return Html::img($model->img,['style'=>'width:120px;height:auto']);
                      }
            ],

            //'slug',
            //'status',
            [
                'attribute'=>'status',
                'label'=>'status',
                'value'=>function(\backend\models\Img $model)
                {
                    return \backend\models\Img::getstatus()[$model->status];
                },
                'filter'=>\backend\models\Img::getstatus(),
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
                        return Html::a('<span class="glyphicon glyphicon-trash btn btn-danger"></span>',$url);
                    }
                ],


            ],
        ],
    ]); ?>


</div>
