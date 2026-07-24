<?php


/* @var $this \yii\web\View */
/* @var $page array|\backend\models\Page|null|\yii\db\ActiveRecord */

/* @var $menus array|\backend\modules\menumanager\models\Menu|null|\yii\db\ActiveRecord */


use yii2assets\pdfjs\PdfJs;

$this->title = $page['title_' . Yii::$app->language];
?>
    <style>
        #imagee img {
            width: 100% !important;
            height: auto !important;
        }

        #imagee iframe {
            width: 100% !important;
            height: 500px !important;
        }

        #imagee tr td {
            border: 1px solid;
        }

        #imagee table {
            width: 100% !important;
            height: auto !important;
        }
    </style>

    <header class="header_section">
        <h1 class="title"><?= $page['title_' . Yii::$app->language] ?></h1>
        <div class="map_site">
            <a href="<?= \yii\helpers\Url::to(['site/index']) ?>"
               class="main_page_link"><?= Yii::t("app", "Home") ?></a>
            <p class="this_page"><i class="fas fa-angle-double-right"></i><?= $page['title_' . Yii::$app->language] ?>
            </p>
        </div>
    </header>

    <section class="rahbariyat">
        <main class="container" style="box-shadow: unset">
            <div class="rahbariyat_menu col-md-3 col-sm-3 ml-2">
                <div class="open_close_button">MENU</div>
                <div class="list-group">
                    <a class="list-group-item active" style="font-size: 16px!important;"><b><?=$menus['title_'.Yii::$app->language]?></b></a>
                    <?php $submenus=$menus->subMenus?>
                    <?php $i=0; foreach ($submenus as $submenu):?>
                        <a href="<?=$submenu->getUrl(['menu_id'=>$menus->id])?>" class="list-group-item " style="font-size: 16px!important;">
                            <?=$submenu['title_'.Yii::$app->language]?>
                        </a>
                    <?php endforeach;?>
                </div>
            </div>
            <div class="info_block col-md-9 col-sm-9">
                <?php if (!empty($leaders)): ?>
                <?php foreach ($leaders as $leader): ?>
                    <div class="info_block_persons ">
                        <div class="info_block_person">
                            <div class="photo_person col-md-3 col-sm-3"
                                 style="border: none !important; width: 230px !important; height: 230px !important;">
                                <img class="photo_person_img" src="<?= $leader['rasm'] ?>" alt="person"
                                     style="object-fit:cover !important;width: 100% !important;height: 100% !important;object-position: center !important;  ">
                            </div>
                            <div class="person_info col-md-9 col-sm-9">
                                <h3><?= $leader['position_' . Yii::$app->language] ?></h3>
                                <h4><?= $leader['name_' . Yii::$app->language] ?></h4>
                                <div class="info">
                                    <div class="info_item">
                                        <h5><i class="far fa-clock"></i> <?= Yii::t("app", "Reception time") ?>:</h5>&nbsp;
                                        <p><?= $leader['reception_days_' . Yii::$app->language] ?></p>
                                    </div>
                                    <div class="info_item">
                                        <h5><i class="fas fa-phone-alt"></i> <?= Yii::t("app", "Phone") ?>:</h5>&nbsp;
                                        <p><?= $leader->phone ?></p>
                                    </div>
                                    <div class="info_item">
                                        <h5><i class="far fa-envelope"></i><?= Yii::t("app", "Email") ?>:</h5>&nbsp;
                                        <p><?= $leader->email ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php endif; ?>
                    <h2 style="text-align: center;font-weight:bold; color: #000064"><?= $page['title_' . Yii::$app->language] ?></h2>
                    <div id="imagee">
                        <?= $page['content_' . Yii::$app->language] ?>
                    </div>
                    <div class="mt-5">
                        <?php
                        if (Yii::$app->language === 'uz'):
                            ?>
                            <?php if ($page['file']!=Null): ?>
                            <?= PdfJs::widget([
                                'url' => $page['file'],
                                'buttons' => [
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
                        elseif (Yii::$app->language === 'en'):
                            ?>
                            <?php if ($page['file_en']!=Null): ?>
                            <?= PdfJs::widget([
                                'url' => $page['file_en'],
                                'buttons' => [
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
                            <?php else:?>
                         <?php if ($page['file_ru']!=Null): ?>
                           <?= PdfJs::widget([
                                'url' => $page['file_ru'],
                                'buttons' => [
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
                        <?php endif; ?>
                    </div>
            </div>

        </main>
    </section>

