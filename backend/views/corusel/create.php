<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Corusel */

$this->title = 'Create Corusel';
$this->params['breadcrumbs'][] = ['label' => 'Corusels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="corusel-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
