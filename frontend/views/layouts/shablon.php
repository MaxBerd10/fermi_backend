<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\widgets\FragmentCache;

\lavrentiev\widgets\toastr\NotificationFlash::widget([
    'options' => [
        "closeButton" => true,
        "debug" => true,
        "newestOnTop" => true,
        "progressBar" => true,
        "positionClass" => \lavrentiev\widgets\toastr\NotificationFlash::POSITION_TOP_RIGHT,
        "preventDuplicates" => true,
        "onclick" => null,
        "showDuration" => "300",
        "hideDuration" => "1000",
        "timeOut" => "5000",
        "extendedTimeOut" => "1000",
        "showEasing" => "swing",
        "hideEasing" => "linear",
        "showMethod" => "fadeIn",
        "hideMethod" => "fadeOut",
    ]
])?>
<?php
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="Farg'ona jamoat salomatligi tibbiyot instituti">
    <meta name="description" content="Farg'ona jamoat salomatligi tibbiyot instituti rasmiy web sayti">
    <meta name="keywords" content="Farg'ona jamoat,Farg'ona jamoat salomatligi,Farg'ona jamoat salomatligi tibbiyot, tibbiyot instituti,jamoat salomatligi instituti,salomatligi,fargona jamoat salomatligi tibbiyot instituti moodle">
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="http://fjsti.uz/">
    <meta property="og:title" content="Farg'ona jamoat salomatligi tibbiyot instituti">
    <meta property="og:description" content="Farg'ona jamoat salomatligi tibbiyot instituti rasmiy web sayti">
    <meta property="og:image" content="">
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="http://fjsti.uz/">
    <meta property="twitter:title" content="Farg'ona jamoat salomatligi tibbiyot instituti">
    <meta property="twitter:description" content="Farg'ona jamoat salomatligi tibbiyot instituti rasmiy web sayti">
    <meta property="twitter:image" content="">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="fancybox-active">
<ul class="social_block_fixed">
    <?$networks=\backend\models\Network::getNetwork()?>
    <?php foreach ($networks as $network):?>
    <li><a href="<?=$network['url']?>" target="_blank" class="hint_left hint_bounce" aria-label="<?=$network['titlte']?>"><i class="fab fa-<?=$network['icon']?>" style="color: #000064"></i></a></li>
    <?php endforeach;?>
</ul>
<?php $this->beginBody() ?>
    <? $setting=\backend\models\Setting::getSetting()?>
    <?  use backend\modules\menumanager\models\Menu;
    $mainMenu = Menu::getMenu('header_menu');
    $logo=\backend\models\Logo::getLogo();
    $setting=\backend\models\Setting::getSetting();
$menus = $mainMenu->activeSubMenus;?>
<?$logo=\backend\models\Logo::getLogo()?>

<section class="header">

    <?php
    // if ($this->beginCache('header_' . Yii::$app->language, [
    //         'duration' => 3600*24,
    //         'variations' => [Yii::$app->language],
    // ])) {

    echo $this->render('header', [
        'menus' => $menus,
        'logo' => $logo,
        'setting' => $setting,
        'networks' => $networks
    ]);

        // $this->endCache();
        // }
    ?>

   
   <?php if (Yii::$app->controller->route=='site/index'):?>
        <? $corusels=\backend\models\Corusel::getCorusel()?>

    <div class="swiper-container mySwiper">
        <div class="swiper-wrapper">
            <?foreach ($corusels as $corusel):?>
            <div class="swiper-slide " style=" background-image: url(<?=$corusel['img']?>);">
                <div class="slider_info_wrapper">
                    <h2 class="slide-title" style="color: #fff !important;"><?=$corusel['title_'.Yii::$app->language]?></h2>
                    <?php if ($corusel['id']==4):?>
                    <a class="more_info" href="https://magistr.edu.uz/login"><?=Yii::t("app","Online registration")?></a>
                    <?php endif;?>
                    <?php if ($corusel['id']==12):?>
                        <a class="more_info" href="https://t.me/fjstiqabul2021"><?=Yii::t("app","Go to channel")?></a>
                    <?php endif;?>
                    <?php if($corusel['id']!=4 && $corusel['id']!=12):?>
                    <a class="more_info" href="<?=\yii\helpers\Url::to(['site/events','id'=>$corusel['id']])?>"><?=Yii::t("app","Read more")?></a>
                    <?php endif;?>
                </div>

            </div>
            <?php endforeach;?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>

</section>
    <?php endif?>
    <?= Alert::widget() ?>
        <?= $content ?>
      <?php
    if ($this->beginCache('footer_' . Yii::$app->language, [
        'duration' => 3600*24, // 1 soat
        'variations' => [Yii::$app->language],
    ])) {

    echo $this->render('footer', [
        'logo' => $logo,
        'setting' => $setting,
        'networks' => $networks,
    ]);

    $this->endCache();
    }
    ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<script>
    window.replainSettings = { id: '8a5b60c2-4cda-4554-8e37-edd8178fb241' };
    (function(u){var s=document.createElement('script');s.type='text/javascript';s.async=true;s.src=u;
        var x=document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);
    })('https://widget.replain.cc/dist/client.js');
</script>