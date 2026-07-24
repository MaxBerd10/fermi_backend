<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Virtual */

$this->title = 'Create Virtual';
$this->params['breadcrumbs'][] = ['label' => 'Virtuals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="virtual-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
