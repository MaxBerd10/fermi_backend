<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\LeaderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leader-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name_uz') ?>

    <?= $form->field($model, 'position_uz') ?>

    <?= $form->field($model, 'position_en') ?>

    <?= $form->field($model, 'position_ru') ?>
    <?= $form->field($model, 'activity_uz') ?>
    <?php // echo $form->field($model, 'biography_uz') ?>

    <?php // echo $form->field($model, 'biography_ru') ?>

    <?php // echo $form->field($model, 'biography_en') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'faks') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'rasm') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
