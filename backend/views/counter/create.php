<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Counter */

$this->title = "Faktlar qo'shish";
$this->params['breadcrumbs'][] = ['label' => 'Counters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="counter-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
