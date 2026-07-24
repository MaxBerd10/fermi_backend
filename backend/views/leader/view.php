<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Leader */

$this->title = "";
$this->params['breadcrumbs'][] = ['label' => 'Leaders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="leader-view">

    <p>
        <? $this->params['update']=Html::a('<span class="glyphicon glyphicon-pencil btn btn-success" style="padding-inline: 15px; font-size: 18px"></span>',['leader/update','id' => $model->id], ['style'=>'margin-right:10px']);?>
        <? $this->params['delete']=Html::a('<span class="glyphicon glyphicon-trash btn btn-danger" style="padding-inline: 15px; font-size: 18px"></span>',['leader/delete','id' => $model->id],['style'=>'margin-right:10px']);?>
        <? $this->params['index']=Html::a('<span class="glyphicon glyphicon-home btn btn-warning" style="padding-inline: 15px; font-size: 18px"></span>',['leader/index']);?>
    </p>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name_uz',
            'position_uz',
            'activity_uz',

            [
                'attribute' => 'biography_uz',
                'label' => 'biography_uz',
                'format' => 'html',
                'value' => function(\backend\models\Leader $model){
                    return mb_substr(strip_tags($model->biography_uz),0,150);
                }
            ],
            //'biography_ru:ntext',
            //'biography_en:ntext',
            'phone',
            'faks',
            'email:email',
            [
                'attribute' => 'rasm',
                'label' => 'rasm',
                'format' => 'html',
                'value' => function(\backend\models\Leader $model){
                    return Html::img($model->rasm,['style'=>'width:120px;height:auto']);
                }
            ],
            [
                'attribute'=>'status',
                'label'=>'status',
                'value'=>function(\backend\models\Leader $model){
                    return \backend\models\Leader::getstatus()[$model->status];
                },
                'filter'=>\backend\models\Leader::getstatus(),
            ],
        ],
    ]) ?>

</div>
