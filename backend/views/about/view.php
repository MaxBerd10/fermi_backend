<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\About */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Abouts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="about-view">


    <p>
        <? $this->params['update']=Html::a('<span class="glyphicon glyphicon-pencil btn btn-success" style="padding-inline: 15px; font-size: 18px"></span>',['about/update','id' => $model->id], ['style'=>'margin-right:10px']);?>
        <? $this->params['delete']=Html::a('<span class="glyphicon glyphicon-trash btn btn-danger" style="padding-inline: 15px; font-size: 18px"></span>',['about/delete','id' => $model->id],['data-method'=>"POST"],['style'=>'margin-right:10px']);?>
        <? $this->params['index']=Html::a('<span class="glyphicon glyphicon-home btn btn-warning" style="padding-inline: 15px; font-size: 18px;margin-left: 10px"></span>',['about/index']);?>
    </p>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title_uz',
            [
                'attribute' => 'content_uz',
                'label' => 'content_uz',
                'format' => 'html',
                'value' => function(\backend\models\About $model)
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
                'value' => function(\backend\models\About  $model){
                    return Html::img($model->img,['style'=>'width:120px;height:auto']);
                }
            ],
            //'content_ru:ntext',
            //'content_en:ntext',
            //'url:url',
            //'img',
            //'slug',
            //'status',
            'url:url',
            // 'img',
            'slug',
            [
                'attribute'=>'status',
                'label'=>'status',
                'value'=>function(\backend\models\About $model)
                {
                    return \backend\models\About::getstatus()[$model->status];
                },
                'filter'=>\backend\models\About::getstatus(),
            ],


           // 'status',
        ],
    ]) ?>

</div>
