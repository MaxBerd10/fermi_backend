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
/* @var $model backend\models\Leader */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leader-form">

    <?php $form = ActiveForm::begin(); ?>
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Uz</a></li>
        <li><a data-toggle="tab" href="#menu1">Ru</a></li>
        <li><a data-toggle="tab" href="#menu2">En</a></li>

    </ul>
    <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
            <?= $form->field($model, 'name_uz')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'position_uz')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'reception_days_uz')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'biography_uz')->widget(CKEditor::className(),[
                'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                    'inline' => false, //по
                ]),
            ]);?>
            <?= $form->field($model, 'activity_uz')->widget(CKEditor::className(),[
                'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                    'inline' => false, //по
                ]),
            ]);?>
        </div>
        <div id="menu1" class="tab-pane fade">
            <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'position_ru')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'reception_days_ru')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'biography_ru')->widget(CKEditor::className(),[
                'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                    'inline' => false, //по
                ]),
            ]);?>
            <?= $form->field($model, 'activity_ru')->widget(CKEditor::className(),[
                'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                    'inline' => false, //по
                ]),
            ]);?>
        </div>
        <div id="menu2" class="tab-pane fade">
            <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'position_en')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'reception_days_en')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'biography_en')->widget(CKEditor::className(),[
                'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                    'inline' => false, //по
                ]),
            ]);?> <?= $form->field($model, 'activity_en')->widget(CKEditor::className(),[
                'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                    'inline' => false, //по
                ]),
            ]);?>

        </div>
    </div>
    <?= $form->field($model, 'category_id')->dropDownList(\yii\helpers\ArrayHelper::map(\backend\models\Leadercategory::find()->all(),'id','title_uz'),['prompt'=>'Select...']) ?>
    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'faks')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'rasm')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control'],
        'buttonOptions' => ['class' => 'btn btn-default'],
        'multiple'      => false       // возможность выбора нескольких файлов
    ]);?>
    <?= $form->field($model, 'status')->widget(SwitchInput::classname(), []); ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
