<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Acceptance */

$this->title = 'Create Acceptance';
$this->params['breadcrumbs'][] = ['label' => 'Acceptances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acceptance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
