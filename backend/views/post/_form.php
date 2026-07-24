<?php

use kartik\datetime\DateTimePicker;
use kartik\switchinput\SwitchInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\web\JsExpression;
$this->registerJs("CKEDITOR.plugins.addExternal('youtube', '/ckeditor/plugins/youtube/plugin.js', '');");

/* @var $this yii\web\View */
/* @var $model backend\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>


                <div class="post-form">
                    <?php $form = ActiveForm::begin(); ?>

                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home">Uz</a></li>
                        <li><a data-toggle="tab" href="#menu1">Ru</a></li>
                        <li><a data-toggle="tab" href="#menu2">En</a></li>

                    </ul>
                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <?= $form->field($model, 'title_uz')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'content_uz')->widget(CKEditor::className(),[
                                'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
                                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                                    'inline' => false, //по
                                    'extraPlugins' => 'youtube',

                                ]),
                            ]);?>
                             <?= $form->field($model, 'file')->widget(InputFile::className(), [
                        'language'      => 'ru',
                        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
                                'filter'        => ['application/pdf'], // Allow only PDF files
                        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                        'options'       => ['class' => 'form-control'],
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'multiple'      => false       // возможность выбора нескольких файлов
                    ]);?>

                        </div>
                        <div id="menu1" class="tab-pane fade">
                            <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'content_ru')->widget(CKEditor::className(),[
                                'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
                                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                                    'inline' => false, //по
                                    'extraPlugins' => 'youtube',

                                ]),
                            ]);?>
                              <?= $form->field($model, 'file_ru')->widget(InputFile::className(), [
                        'language'      => 'ru',
                        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
                                'filter'        => ['application/pdf'], // Allow only PDF files
                        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                        'options'       => ['class' => 'form-control'],
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'multiple'      => false       // возможность выбора нескольких файлов
                    ]);?>
                        </div>
                        <div id="menu2" class="tab-pane fade">
                            <?= $form->field($model, 'title_en')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'content_en')->widget(CKEditor::className(),[
                                'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
                                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                                    'inline' => false, //по
                                    'extraPlugins' => 'youtube',

                                ]),
                            ]);?>
                              <?= $form->field($model, 'file_en')->widget(InputFile::className(), [
                        'language'      => 'ru',
                        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
                                'filter'        => ['application/pdf'], // Allow only PDF files
                        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                        'options'       => ['class' => 'form-control'],
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'multiple'      => false       // возможность выбора нескольких файлов
                    ]);?>
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
                    <?= $form->field($model, 'category_id')->dropDownList(\yii\helpers\ArrayHelper::map(\backend\models\Postcategory::find()->all(),'id','title_uz'),['prompt'=>'Categoryani tanlang...']) ?>

                    <?= $form->field($model,'date')->widget(DateTimePicker::classname(),[
                        'value' => '2020- 08-16 14:17',
                        'options' => ['placeholder' => 'Select operating time ...'],
                        'convertFormat' => true,
                        'pluginOptions' => [
                            'format' => ' yyyy-M-dd HH:i',
                            'todayHighlight' => true,
                        ]
                    ]);
                    ?>
                    <?= $form->field($model, 'meta_key')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'status')->widget(SwitchInput::classname(), []); ?>
                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
