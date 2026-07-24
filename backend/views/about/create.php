<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\About */

$this->title = 'Biz haqimizda';
$this->params['breadcrumbs'][] = ['label' => 'Abouts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="about-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
