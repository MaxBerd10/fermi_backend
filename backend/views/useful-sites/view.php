<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\UsefulSites */

$this->title ="";
$this->params['breadcrumbs'][] = ['label' => 'Useful Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="useful-sites-view">


    <p>
        <? $this->params['update']=Html::a('<span class="glyphicon glyphicon-pencil btn btn-success" style="padding-inline: 15px; font-size: 18px"></span>',['useful-sites/update','id' => $model->id], ['style'=>'margin-right:10px']);?>
        <? $this->params['delete']=Html::a('<span class="glyphicon glyphicon-trash btn btn-danger" style="padding-inline: 15px; font-size: 18px"></span>',['useful-sites/delete','id' => $model->id],['data-method'=>"POST"],['style'=>'margin-right:10px']);?>
        <? $this->params['index']=Html::a('<span class="glyphicon glyphicon-home btn btn-warning" style="padding-inline: 15px; font-size: 18px;margin-left: 10px"></span>',['useful-sites/index']);?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title_uz',
            'title_ru',
            'title_en',
            [
                'attribute' => 'img',
                'label' => 'img',
                'format' => 'html',
                'value' => function(\backend\models\UsefulSites $model)
                {
                    return Html::img($model->img,['style'=>'width:120px; height:auto']);
                }
            ],
            [
                'attribute'=>'status',
                'label'=>'status',
                'value'=>function(\backend\models\UsefulSites $model){
                    return \backend\models\UsefulSites::getstatus()[$model->status];
                },
                'filter'=>\backend\models\UsefulSites::getstatus(),
            ],
            'url',
        ],
    ]) ?>

</div>
