<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Virtual */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Virtuals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="virtual-view">

    <p>
        <? $this->params['delete']=Html::a('<span class="glyphicon glyphicon-trash btn btn-danger" style="padding-inline: 15px; font-size: 18px"></span>',['acceptance/delete','id' => $model->id],['data-method'=>"POST"],['style'=>'margin-right:10px']);?>
        <? $this->params['index']=Html::a('<span class="glyphicon glyphicon-home btn btn-warning" style="padding-inline: 15px; font-size: 18px;margin-left: 10px"></span>',['acceptance/index2']);?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fish',
           // 'province',
            [
                    'attribute'=>'province',
                'label'=>'Viloyat',
                'value'=>function(\backend\models\Virtual $model)
                {
                    return $model->province0->name;
                }
            ],
            //'fog',
            [
                    'attribute'=>'fog',
                'label'=>'Tuman',
                'value'=>function(\backend\models\Virtual $model)
                {
                    return $model->fog0->name;
                }
            ],
            'address',
            'phone',
            'email:email',
            'gender',
            [
                'attribute'=>'faculty_id',
                'label'=>'Fakultet',
                'value'=>function(\backend\models\Virtual $model)
                {
                    return $model->faculty->title_uz;
                }
            ],
            'text:ntext',
           // 'file',
            [
                    'attribute'=>'file',
                'label'=>'file',
                'format'=>'raw',
                'value'=>function(\backend\models\Virtual $model)
                {
                    return Html::a('<span >File</span>',"/frontend/web/uploads/virtual/".$model->file);
                }
            ],
            [
                'attribute' => 'status',
                'label' => 'status',
                'value' => function(\backend\models\Virtual $model)
                {
                    return \backend\models\Virtual::getstatus()[$model->status];
                },
                'filter' => \backend\models\Virtual::getstatus(),
            ],
            'created_at:dateTime',
        ],
    ]) ?>

</div>
