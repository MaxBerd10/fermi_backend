<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ConnectLeader */

$this->title = 'Create Connect Leader';
$this->params['breadcrumbs'][] = ['label' => 'Connect Leaders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="connect-leader-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
