<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VirtualSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Virtuals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="virtual-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Virtual', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php \yii\widgets\Pjax::begin() ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fish',
            'province',
            'fog',
            'address',
            'created_at:datetime',
            //'phone',
            //'email:email',
            //'gender',
            //'faculty_id',
            //'text:ntext',
            //'file',
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


    <?php \yii\widgets\Pjax::end() ?>

</div>
