<?php


use kartik\date\DatePicker;
/* @var $this \yii\web\View */
/* @var $model \backend\models\Acceptance */

use kartik\form\ActiveForm;
use yii\widgets\MaskedInput;
$this->title=Yii::t("app","Sign up for a leadership meeting");
?>

<header class="header_section">
    <h1 class="title"><?=Yii::t("app","Sign up for a leadership meeting");?></h1>
    <div class="map_site">
        <a href="index.html" class="main_page_link"><?=Yii::t("app","Sign up for a leadership meeting");?></a>
        <p class="this_page"> <i class="fas fa-angle-double-right"></i> <?=Yii::t('app','Qabulga yozilish');?></p>
    </div>
</header>
<section class="qabulxona">
    <main class="container">
        <?php $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['site/qabul']),'id' => 'contact-form', 'options' => [
        'class'=>'vp_form',
        'method'=>'post'
        ]]); ?>

            <div class="form_input rahbar">
                <label for="viloyat"><?=Yii::t('app','Rahbar tanlang');?> <span>*</span></label>
                <select id="rahbar" class="form-control" name="rahbar">
                    <option><?=Yii::t('app','Rahbar tanlang');?></option>
                    <?  $leaders=\backend\models\ConnectLeader::getConnect()?>
                    <?php foreach ($leaders as $leader):?>
                    <option value="<?=$leader['id']?>" name="rahbar"><?=$leader['name']?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form_input f_name">
                <label for="fmane"><?=Yii::t('app','Vaqti');?> <span>*</span></label>
                <?=$form->field($model, 'date')->widget(DatePicker::classname(), [
                    'options' => [
                            'placeholder' =>Yii::t('app','Enter birth date'),

                    ],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format'=>'yyyy-mm-dd'
                    ]
                ])->label(false);?>
            </div>
            <div class="form_input date">
                <label for="fmane"><?=Yii::t('app','Qabul mavzusi');?> <span>*</span></label>
                <?= $form->field($model, 'subject')->textInput(['autofocus' => false])->input('subject', ['placeholder' => Yii::t('app','Qabul mavzusi'),])->label(false) ?>
            </div>
            <div class="form_input f_name">
                <label for="fmane"><?=Yii::t('app','F.I.O');?> <span>*</span></label>
               <?= $form->field($model, 'fish')->textInput(['autofocus' => false])->input('fish', ['placeholder' => Yii::t('app','Ism familyangizni kiriting'),])->label(false) ?>

            </div>
          <div class="form_input viloyat">
            <label for="viloyat"><?=Yii::t('app','Viloyat');?> <span>*</span></label>
            <select required id="viloyat" class="form-control regions" name="viloyat" placeholder="Toshkent shahar">
                <?php $regions=\backend\models\Regions::getRegions()?>
                <option>---</option>
                <?php foreach ($regions as $region):?>
                    <option value="<?=$region['id']?>" name="viloyat"><?=$region['name']?></option>
                <?php endforeach;?>
            </select>
        </div>
          <div class="form_input tuman">
            <label for="tuman"><?=Yii::t('app','Tuman');?> <span>*</span></label>
            <select required id="tuman" class="form-control districts" name="tuman" placeholder="Quva" aria-required="true"
                    aria-invalid="true">
                <option value=""><?=Yii::t('app','Tuman');?></option>
            </select>
        </div>
           <div class="form_input address">
            <label for="manzil"><?=Yii::t('app','Manzil');?> <span>*</span></label>
            <select required id="manzil" class="form-control quartes" name="manzil" aria-required="true"
                    aria-invalid="true">
                <option value=""><?=Yii::t('app','Manzil');?></option>
            </select>
        </div>
        <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
            'mask' => '\+\9\9\8 99 999 99 99',
            'options' => [
                'minlength' => 17,
                'autofocus' => true
            ]
        ])->label(false) ?>
            <div class="form_input email">
                <label for="email"><?=Yii::t('app','Email');?> <span>*</span></label>
                <?= $form->field($model, 'email')->textInput(['autofocus' => false])->input('email', ['placeholder' => Yii::t('app','Email')])->label(false) ?>
            </div>
            <p class="form_requaired_info">
                <?=Yii::t('app','Diqqat');?>! <span>"*"</span> <?=Yii::t('app','Belgisi bor joylar to`ldirilishi shart');?>!
            </p>
            <button type="submit" class="btn-primary"><?=Yii::t('app','Jo`natish');?></button>
        <?php ActiveForm::end(); ?>
    </main>
</section>
<?php
$js = <<<JS
$("select.regions").change(function(){
        document.getElementById("tuman").innerHTML = "";
        var selectedRegion = $(this).children("option:selected").val();
       $.ajax({
       url:'/site/disrtict',
       type:'GET',
       data:{id:selectedRegion},
       success:function (data)
       {
               $('#tuman').append("<option value=''>"+ "Tumani tanlang" +"</option>")               
               for (i=0; i<data['districts'].length; i++)
               {
                $('#tuman').append("<option value='"+data['districts'][i]['id']+"'  name='tuman'>"+data['districts'][i]['name']+"</option>")               
               }
       }
       })
});
$("select.districts").change(function (){
    var selectedistrict=$(this).children("option:selected").val();
      document.getElementById("manzil").innerHTML = "";
      $.ajax({
      url:'/site/address',
      type:"GET",
      data:{id:selectedistrict},
      success:function (data){
        $('#manzil').append("<option value=''>"+ "Manzilni tanlang" +"</option>")
          for (i=0;i<data['address'].length;i++){
              $("#manzil").append("<option value='"+data['address'][i]['id']+"' name='manzil'>"+data['address'][i]['name']+"</option>")            
          }
      }
      })
})
JS;
$this->registerJs($js)
?>