<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UsefulSites */

$this->title = 'Create Useful Sites';
$this->params['breadcrumbs'][] = ['label' => 'Useful Sites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="useful-sites-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
