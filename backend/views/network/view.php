<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Network */

$this->title = "";
$this->params['breadcrumbs'][] = ['label' => 'Networks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="network-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <? $this->params['update']=Html::a('<span class="glyphicon glyphicon-pencil btn btn-success" style="padding-inline: 15px; font-size: 18px"></span>',['network/update','id' => $model->id], ['style'=>'margin-right:10px']);?>
        <? $this->params['delete']=Html::a('<span class="glyphicon glyphicon-trash btn btn-danger" style="padding-inline: 15px; font-size: 18px"></span>',['network/delete','id' => $model->id],['data-method'=>"POST"],['style'=>'margin-right:10px']);?>
        <? $this->params['index']=Html::a('<span class="glyphicon glyphicon-home btn btn-warning" style="padding-inline: 15px; font-size: 18px;margin-left: 10px"></span>',['network/home']);?>
    </p>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'titlte',
            'icon',
            'url:url',
            'status',
        ],
    ]) ?>

</div>
