<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://pro.fontawesome.com/releases/v5.10.0/css/all.css',
        'css/fancybox.css',
        'js/OwlCarousel2/dist/assets/owl.carousel.min.css',
        'css/swiper-bundle.min.css',
        'css/main.css',
        'css/responsive.css',
        'css/my.css',
        'css/custom.css',
    ];
    public $js = [

        'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js',
        'js/fancy.js',
        'js/swiper-bundle.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',
        'js/OwlCarousel2/dist/owl.carousel.min.js',
        'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js',
        'js/script.js',
        'js/custom.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
