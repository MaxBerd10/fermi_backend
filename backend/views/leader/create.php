<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Leader */

$this->title = 'Create Leader';
$this->params['breadcrumbs'][] = ['label' => 'Leaders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leader-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
