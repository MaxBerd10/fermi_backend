<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use kartik\form\ActiveForm;
$this->title=Yii::t("app","contact")
/** @var \backend\models\Contact $model */
/** @var \backend\modules\menumanager\models\Menu $menu */


?>
<section class="page-content pb-5">
    <div class="page-content-header">
        <div class="container">
            <h3 class="size30 text-center">
              <?=$this->title?>
            </h3>
        </div>
    </div>
    <div class="page-content-section py-4">
        <div class="container ">
            <div class="row">
                <div class="col-lg-8">
                    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                   <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                    <?= $form->field($model, 'subject') ?>
                    <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
                        'mask' => '\+\9\9\8 99 999 99 99',
                        'options' => [
                            'required'=>'true',
                            'placeholder'=>'Telefon raqamingiz',
                        ]
                    ])->label(false) ?>
                    <?= $form->field($model, 'email') ?>
                    <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>
                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t("app","send message"), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
                <div class="col-lg-4 sidebar">
                     <?=$this->render('right_menu')?>
                </div>
            </div>
        </div>
    </div>
</section>
