<?php

use kartik\switchinput\SwitchInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Leadercategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leadercategory-form">

    <?php $form = ActiveForm::begin(); ?>
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Uz</a></li>
        <li><a data-toggle="tab" href="#menu1">Ru</a></li>
        <li><a data-toggle="tab" href="#menu2">En</a></li>

    </ul>

    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <?= $form->field($model, 'title_uz')->textInput(['maxlength' => true]) ?>
        </div>
        <div id="menu1" class="tab-pane fade">
            <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>

        </div>
        <div id="menu2" class="tab-pane fade">
            <?= $form->field($model, 'title_en')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <?= $form->field($model, 'is_faculty')->widget(SwitchInput::classname(), []); ?>
    <?= $form->field($model, 'status')->widget(SwitchInput::classname(), []); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
