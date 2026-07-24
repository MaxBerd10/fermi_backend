<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UsefulSites */

$this->title = 'Update Useful Sites: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Useful Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="useful-sites-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
