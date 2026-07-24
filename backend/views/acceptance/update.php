<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Acceptance */

$this->title = 'Update Acceptance: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Acceptances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="acceptance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
