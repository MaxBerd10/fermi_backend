<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model backend\models\Acceptance */

$this->title ='';
$this->params['breadcrumbs'][] = ['label' => 'Acceptances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="acceptance-view">

    <p>
        <? $this->params['delete']=Html::a('<span class="glyphicon glyphicon-trash btn btn-danger" style="padding-inline: 15px; font-size: 18px"></span>',['acceptance/delete','id' => $model->id],['data-method'=>"POST"],['style'=>'margin-right:10px']);?>
        <? $this->params['index']=Html::a('<span class="glyphicon glyphicon-home btn btn-warning" style="padding-inline: 15px; font-size: 18px;margin-left: 10px"></span>',['acceptance/index']);?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
           // 'category_id',
            [
                    'attrebute'=>'category_id',
                'label'=>'Rahbariyat',
                'value'=>function(\backend\models\Acceptance $model)
                {
                    return $model->category->name;
                }
            ],
            'date',
            'subject',
            'fish',
            'phone',
            'email:email',
            //'region_id',
            [
                    'attribute'=>'region_id',
                'label'=>'Viloyat',
                'value'=>function(\backend\models\Acceptance $model)
                {
                    return $model->region->name ;
                }
            ],
            [
                'attribute' => 'district_id',
                'label' => 'Tuman',
                'value' => function (\backend\models\Acceptance $model) {
                    return $model->district->name;
                }
            ],
            [
                    'attribute'=>'quater_id',
                'label'=>'Manzil',
                'value'=>function(\backend\models\Acceptance $model)
                {
                    return $model->quater->name;
                }
            ],
            [
                'attribute' => 'status',
                'label' => 'status',
                'value' => function(\backend\models\Acceptance $model)
                {
                    return \backend\models\Acceptance::getstatus()[$model->status];
                },
                'filter' => \backend\models\Acceptance::getstatus(),
            ],
        ],
    ]) ?>


</div>
