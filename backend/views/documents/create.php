<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Documents */

$this->title = "Hujjat qo'shish";
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="documents-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
