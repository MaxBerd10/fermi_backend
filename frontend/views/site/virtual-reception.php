<?php
$this->title=Yii::t("app","Virtual reception");
?>
<header class="header_section">
    <h1 class="title"><?=Yii::t("app","Virtual reception")?></h1>
    <div class="map_site">
        <a href="<?=\yii\helpers\Url::to(['site/index'])?>" class="main_page_link"><?=Yii::t('app','Home');?></a>
        <p class="this_page"> <i class="fas fa-angle-double-right"></i><?=Yii::t("app","Virtual reception")?></p>
    </div>
</header>
<style>
    .virtual_qabulxona img{
     width:100%;
     height:auto;
     object-fit:cover;
    }
</style>
<section class="virtual_qabulxona">
    <div class="container" style="margin-top:20px;margin-bottom-20px">
            <img src="/frontend/web/virtual.jpg">

    </div>
    <main class="container"  style="margin-top:20px">
        <?php use kartik\form\ActiveForm;
        use yii\widgets\MaskedInput;
        $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['site/virtual-reception']),'id' => 'contact-form', 'options' => [
            'class'=>'vp_form col-md-8 col-sm-8',
            'enctype' => 'multipart/form-data'
             ]]); ?>
            <div class="form_input f_name">
                <label for="fmane"><?=Yii::t('app','Your firstname');?> <span>*</span></label>
                <?= /** @var TYPE_NAME $model */
                $form->field($model, 'fish')->textInput(['autofocus' => false])->label(false) ?>
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
            <div class="form_input manzil">
                <label for="manzil"><?=Yii::t("app","Manzil")?> <span>*</span></label>
                <select required id="manzil" class="form-control quartes" name="manzil" aria-required="true"
                        aria-invalid="true">
                    <option value=""><?=Yii::t("app","Manzil")?></option>
                </select>
            </div>
            <div class="form_input phone">
                <label for="phone"><?=Yii::t('app','Telefon Raqami');?> <span>*</span></label>
                <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                    'mask' => '\+\9\9\8 99 999 99 99',
                    'options' => [
                        'minlength' => 17,
                        'autofocus' => true
                    ]
                ])->label(false) ?>
            </div>
            <div class="form_input email">
                <label for="email"><?=Yii::t('app','Email');?> <span>*</span></label>
                <?= $form->field($model, 'email')->label(false) ?>
            </div>
            <div class="form_input gender">
                <label for="email"><?=Yii::t('app','Jinsingiz');?> <span>*</span></label>
                <input required type="radio" class="" value="Erkak" id="male" name="gender">
                <label for="male"><?=Yii::t('app','Erkak');?></label>
                <input type="radio" class="" value="Ayol" id="female" name="gender">
                <label for="female"><?=Yii::t('app','Ayol');?></label>
            </div>
        <div class="form_input ">
            <label for="email">Shaxs turi<span>*</span></label>
            <input required type="radio" class="" value="Jismoniy  " id="jismoniy shaxs" name="jismoniy  ">
            <label for="male">Jismoniy  </label>
            <input type="radio" class="" value="Yuridik " id="Yuridik " name="Yuridik">
            <label for="female">Yuridik</label>
        </div>
            <div class="form_input fakultet">
                <label for="fakultet"><?=Yii::t('app','Fakultetni tanlang');?> <span>*</span></label>
                <select required id="fakultet" class="form-control" name="fakultet" placeholder="-- Fakultet">
                    <?php $faculty=\backend\models\Faculty::getFaculty()?>
                    <option value=""><?=Yii::t('app','Fakultetni tanlang');?></option>
                    <?php foreach ($faculty as $facult): ?>
                    <option value="<?=$facult['id']?>" name="fakultet"><?=$facult['title_'.Yii::$app->language]?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form_input murojaat">
                <label for="text_area_murojaat"><?=Yii::t('app','Murojaat matni');?> <span>*</span></label>
                <?= $form->field($model, 'text')->textarea(['rows' => 6])->label(false) ?>

            </div>
            <div class="form_input file">
                <label for="file"><?=Yii::t('app','Faylni yuklash');?></label>
                <?= $form->field($model, 'file')->fileInput()->label(false) ?>
            </div>
            <p class="form_requaired_info">
                <?=Yii::t('app','Diqqat');?>! <span>"*"</span> <?=Yii::t('app','Belgisi bor joylar to`ldirilishi shart');?>!
            </p>
            <button type="submit" class="btn-primary"><?=Yii::t('app','Jo`natish');?></button>
        <?php ActiveForm::end(); ?>
        <div class="person_info col-md-4 col-sm-4">
            <?$rektor=\backend\models\Leader::find()->where(['category_id'=>1])->one()?>
            <h3 style="text-transform: uppercase"><?=Yii::t('app','REKTOR');?>: <?=$rektor['name_'.Yii::$app->language]?></h3>
            <div class="header_top_info">
                <div class="header_top_info_item">
                    <i class="far fa-clock"></i>
                    <div class="header_top_info_item_text">
                        <p><?=Yii::t('app','Reception time');?>:</p>
                        <h2><?=Yii::t('app','вторник');?>: <?=$rektor['reception_days_'.Yii::$app->language]?> Payshanba: <?=$rektor['reception_days_'.Yii::$app->language]?></h2>
                    </div>
                </div>
                <div class="header_top_info_item">
                    <i class="fas fa-phone-alt"></i>
                    <div class="header_top_info_item_text">
                        <p><?=Yii::t('app','Phone');?></p>
                        <h2><?=$rektor->phone?></h2>
                    </div>
                </div>
                <div class="header_top_info_item">
                    <i class="far fa-envelope"></i>
                    <div class="header_top_info_item_text">
                        <p><?=Yii::t("app","Email")?></p>
                        <h2><?=$rektor->email?></h2>
                    </div>
                </div>
                <div class="header_top_info_item">
                    <i class="fas fa-fax"></i>
                    <div class="header_top_info_item_text">
                        <p><?=Yii::t("app","Fax")?>:</p>
                        <h2><?=$rektor->faks?></h2>
                    </div>
                </div>
            </div>
        </div>
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
              $("#manzil").append("<option value='"+data['address'][i]['name']+"' name='manzil'>"+data['address'][i]['name']+"</option>")            
          }
      }
      })
})
JS;
$this->registerJs($js)
?>