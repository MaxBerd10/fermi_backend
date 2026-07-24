<?php



/* @var $this \yii\web\View */
/* @var $news array|\backend\models\Post|null|\yii\db\ActiveRecord */

use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii2assets\pdfjs\PdfJs;
$this->title=Yii::t("app","News")
?>
<style>
    #newss img{
        width: 100%!important;
        height: auto!important;
        margin-bottom: 10px!important;
    }
</style>

<header class="header_section">
    <h1 class="title"><?=Yii::t("app","News")?></h1>
    <div class="map_site">
        <a href="<?=\yii\helpers\Url::to(['site/index'])?>" class="main_page_link"><?=Yii::t("app","Home")?></a>
        <p class="this_page"> <i class="fas fa-angle-double-right"></i><?=Yii::t("app","News")?></p>
    </div>
</header>
<section class="page-content pb-5">
    <div class="page-content-section py-4">
        <div class="container ">
            <div class="row">
                <div class="col-lg-8 "  id="newss">
                    <h2 style="text-align: center;font-weight:bold;z"><?=$news['title_'.Yii::$app->language]?></h2>
                    <?=$news['content_'.Yii::$app->language]?>
                    <div class="mt-5">
                        <?php
                        if(Yii::$app->language=='uz'):
                            ?>
                            <?php if ($news->file!=Null):?>
                            <?= PdfJs::widget([
                                'url'=>$news->file,
                                'buttons'=>[
                                    'presentationMode' => 'false',
                                    'openFile' => 'false',
                                    'print' => 'true',
                                    'download' => 'true',
                                    'viewBookmark' => 'false',
                                    'secondaryToolbarToggle' => 'false'
                                ]
                            ]);
                            ?>
                        <?php endif;
                            ?>
                        <?php
                        elseif (Yii::$app->language=='en'):
                            ?>
                            <?php if ($news->file_en!=Null):?>
                            <?= PdfJs::widget([
                                'url'=>$news->file_en,
                                'buttons'=>[
                                    'presentationMode' => 'false',
                                    'openFile' => 'false',
                                    'print' => 'true',
                                    'download' => 'true',
                                    'viewBookmark' => 'false',
                                    'secondaryToolbarToggle' => 'false'
                                ]
                            ]);
                            ?>
                        <?php endif;
                            ?>

                        <?php elseif(Yii::$app->language=='ru'): ?>

                            <?php if ($news->file_ru!=Null):?>
                                <?= PdfJs::widget([
                                    'url'=>$news->file_ru,
                                    'buttons'=>[
                                        'presentationMode' => 'false',
                                        'openFile' => 'false',
                                        'print' => 'true',
                                        'download' => 'true',
                                        'viewBookmark' => 'false',
                                        'secondaryToolbarToggle' => 'false'
                                    ]
                                ]);
                                ?>
                            <?php endif;
                            ?>

                        <?php   endif;
                        ?>
                    </div>

                  

                </div>
                <div class="col-lg-4 sidebar">
                    <ul class="main-menu__list">
                        <li class="active"><a href="/news"><?= /** @var TYPE_NAME $menus */
                                $menus['title_'.Yii::$app->language]?></a></li>
                        <?$submenus=$menus->subMenus?>
                        <?php foreach ($submenus as $submenu):?>
                            <li><a href="<?=$submenu->getUrl(['menu_id' => $menus->id ]) ?>"><?=$submenu['title_'.Yii::$app->language]?></a></li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
