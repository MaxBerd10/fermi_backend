<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Virtual */

$this->title = 'Update Virtual: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Virtuals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="virtual-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
