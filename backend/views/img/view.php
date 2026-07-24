<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Img */

$this->title = "";
$this->params['breadcrumbs'][] = ['label' => 'Imgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="img-view">

    <p>
        <? $this->params['update']=Html::a('<span class="glyphicon glyphicon-pencil btn btn-success" style="padding-inline: 15px; font-size: 18px"></span>',['img/update','id' => $model->id], ['style'=>'margin-right:10px']);?>
        <? $this->params['delete']=Html::a('<span class="glyphicon glyphicon-trash btn btn-danger" style="padding-inline: 15px; font-size: 18px"></span>',['img/delete','id' => $model->id],['data-method'=>"POST"],['style'=>'margin-right:10px']);?>
        <? $this->params['index']=Html::a('<span class="glyphicon glyphicon-home btn btn-warning" style="padding-inline: 15px; font-size: 18px;margin-left: 10px"></span>',['img/index']);?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title_uz',
            //'title_ru',
            //'title_en',
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
            [
                'attribute' => 'img',
                'label' => 'img',
                'format' => 'html',
                'value' => function(\backend\models\Img  $model){
                    return Html::img($model->img,['style'=>'width:120px;height:auto']);
                }
            ],
            'slug',
            [
                'attribute'=>'status',
                'label'=>'status',
                'value'=>function(\backend\models\Img $model)
                {
                    return \backend\models\Img::getstatus()[$model->status];
                },
                'filter'=>\backend\models\Img::getstatus(),
            ],
        ],
    ]) ?>

</div>
