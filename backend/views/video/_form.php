<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\switchinput\SwitchInput;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model backend\models\Video */
/* @var $form yii\widgets\ActiveForm */
$this->params['content']=1;
?>

<div class="video-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="box box-default">
        <div class="box-body">
            <div class="col-md-6">
                <input type="radio" name="radio" id="click1">video
                <input type="radio" name="radio" id="click2">url
                <div id="video" style="display: block">
                    <?= $form->field($model, 'video')->widget(InputFile::className(), [
                        'language'      => 'ru',
                        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
                        'filter'        => 'video',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
                        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                        'options'       => ['class' => 'form-control'],
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'multiple'      => false       // возможность выбора нескольких файлов
                    ]);?>
                </div>
                <div id="url" style="display: none">
                    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <div class="col-md-6" style="margin-top: 20px">
                <?= $form->field($model, 'status')->widget(SwitchInput::classname(), []); ?>
            </div>
            </div>


        <?php ActiveForm::end(); ?>

    </div>
    </div>
<?php
$js = <<<JS
   $("#click1").on('click',function (){
      $('#video').css('display','block')
      $('#url').css('display','none')

   })
   $("#click2").on('click',function (){
      $('#video').css('display','none')
      $('#url').css('display','block')

   })
JS;
$this->registerJs($js);
?>

