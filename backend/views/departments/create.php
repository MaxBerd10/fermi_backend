<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Departments */

$this->title = "Kafedralar qo'shish";
$this->params['breadcrumbs'][] = ['label' => 'Departments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="departments-create">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
</div>
