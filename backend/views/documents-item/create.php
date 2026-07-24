<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Documentsitem */

$this->title = 'Hujjat';
$this->params['breadcrumbs'][] = ['label' => 'Documentsitems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documentsitem-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
