<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Leadercategory */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Leadercategories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="leadercategory-view">


    <p>
        <? $this->params['update']=Html::a('<span class="glyphicon glyphicon-pencil btn btn-success" style="padding-inline: 15px; font-size: 18px"></span>',['leadercategory/update','id' => $model->id], ['style'=>'margin-right:10px']);?>
        <? $this->params['delete']=Html::a('<span class="glyphicon glyphicon-trash btn btn-danger" style="padding-inline: 15px; font-size: 18px; margin-right: 10px;"></span>',['leadercategory/delete','id' => $model->id]);?>
        <? $this->params['index']=Html::a('<span class="glyphicon glyphicon-home btn btn-warning" style="padding-inline: 15px; font-size: 18px"></span>',['leadercategory/index']);?>
    </p>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'titlte_uz',
            'title_ru',
            'title_en',
            'slug',
            'status',
        ],
    ]) ?>

</div>
