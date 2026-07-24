<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Img */

$this->title = 'Create Img';
$this->params['breadcrumbs'][] = ['label' => 'Imgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="img-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
