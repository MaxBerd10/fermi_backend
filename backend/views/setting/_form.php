<?php

use kartik\switchinput\SwitchInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-form">

    <?php $form = ActiveForm::begin(); ?>
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Uz</a></li>
        <li><a data-toggle="tab" href="#menu1">Ru</a></li>
        <li><a data-toggle="tab" href="#menu2">En</a></li>

    </ul>
    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <?= $form->field($model, 'address_uz')->textInput(['maxlength' => true]) ?>
        </div>
        <div id="menu1" class="tab-pane fade">
            <?= $form->field($model, 'address_ru')->textInput(['maxlength' => true]) ?>
        </div>
        <div id="menu2" class="tab-pane fade">
            <?= $form->field($model, 'address_en')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'faks')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->widget(SwitchInput::classname(), []); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
