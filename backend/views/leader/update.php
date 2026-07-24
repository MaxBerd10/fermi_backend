<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Leader */

$this->title = "";
$this->params['breadcrumbs'][] = ['label' => 'Leaders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name_uz, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="leader-update">

    <? $this->params['delete']=Html::a('<span class="glyphicon glyphicon-trash btn btn-danger" style="padding-inline: 15px; font-size: 18px"></span>',['leader/delete','id' => $model->id],['data-method'=>"POST"],['style'=>'margin-right:10px']);?>
    <? $this->params['index']=Html::a('<span class="glyphicon glyphicon-home btn btn-warning" style="padding-inline: 15px; font-size: 18px;margin-left: 10px"></span>',['leader/index']);?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
