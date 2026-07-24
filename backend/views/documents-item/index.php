<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DocumentsItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hujatlar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documentsitem-index">

    <p>
        <? $this->params['create']=Html::a('<span class="glyphicon glyphicon-plus btn btn-success" ></span>',['documents-item/create'],['style'=>'margin-right:10px']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class'=>\yii\grid\SerialColumn::class,
                'contentOptions'=>function(\backend\models\DocumentsItem $model){
                    $class='';
                    switch ($model->status)
                    {
                        case \backend\models\DocumentsItem::STATUS_SHOWED:$class='alert-success';break;
                        case \backend\models\DocumentsItem::STATUS_NOTSHOWED:$class='alert-danger';break;
                        default:$class='alert-info';
                    }
                    return['class'=>$class];
                }
            ],

           // 'id',
            'title_uz',
            //'title_ru',
           // 'title_en',
            [
                'attribute'=>'content_uz',
                'label'=>'content_uz',
                'format'=>'html',
                'value'=>function(\backend\models\DocumentsItem $model){
                    return mb_substr(strip_tags($model->content_uz),0,120);
                }
            ],
            //'content_ru:ntext',
            //'content_en:ntext',
            //'document_id',
            [
                    'attribute' => 'documents_id',
                'label' => 'hujatt turi',
                'value' => function(\backend\models\DocumentsItem $model){
                return $model->document->title_uz;
                }
            ],
            //'slug',
            //'status',

            [
                'attribute'=>'status',
                'label'=>'status',
                'value'=>function(\backend\models\DocumentsItem $model){
                    return \backend\models\DocumentsItem::getstatus()[$model->status];
                },
                'filter'=>\backend\models\DocumentsItem::getstatus(),
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
