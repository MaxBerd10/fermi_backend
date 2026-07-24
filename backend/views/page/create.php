<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Page */

$this->title = "Sahifa qo'shish";
$this->params['breadcrumbs'][] = ['label' => 'Sahifa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
