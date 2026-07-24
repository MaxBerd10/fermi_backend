<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Departments */

$this->title= '' ;
$this->params['breadcrumbs'][] = ['label' => 'Departments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="departments-view">
    <p>
        <? $this->params['update']=Html::a('<span class="glyphicon glyphicon-pencil btn btn-success" style="padding-inline: 15px; font-size: 18px"></span>',['departments/update','id' => $model->id], ['style'=>'margin-right:10px']);?>
        <? $this->params['delete']=Html::a('<span class="glyphicon glyphicon-trash btn btn-danger" style="padding-inline: 15px; font-size: 18px"></span>',['departments/delete','id' => $model->id],['style'=>'margin-right:10px']);?>
        <? $this->params['index']=Html::a('<span class="glyphicon glyphicon-home btn btn-warning" style="padding-inline: 15px; font-size: 18px"></span>',['departments/index']);?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title_uz',
           // 'title_ru',
          //  'title_en',
            [
                'attribute'=>'content_uz',
                'label'=>'content_uz',
                'format'=>'html',
                'value'=>function(\backend\models\Departments $model){
                    return mb_substr(strip_tags($model->content_uz),0,200);
                }
            ],
            'slug',
            'status',
            ],
    ]) ?>

</div>
