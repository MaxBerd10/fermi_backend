<?php

use kartik\datetime\DateTimePicker;
use kartik\switchinput\SwitchInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model backend\models\UsefulSites */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="useful-sites-form">

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
    <?= $form->field($model, 'img')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control'],
        'buttonOptions' => ['class' => 'btn btn-default'],
        'multiple'      => false       // возможность выбора нескольких файлов
    ]);?>
    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->widget(SwitchInput::classname(), []); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
