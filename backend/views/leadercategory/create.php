<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Leadercategory */

$this->title = 'Rahbariyat';
$this->params['breadcrumbs'][] = ['label' => 'Leadercategories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leadercategory-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
