<?php



/* @var $this \yii\web\View */
/* @var $leaders array|\backend\models\Leader[]|\yii\db\ActiveRecord[] */
/* @var $menus array|\backend\modules\menumanager\models\Menu|null|\yii\db\ActiveRecord */
/** @var TYPE_NAME $category */
$this->title=$category['title_'.Yii::$app->language];
?>
<header class="header_section">
    <h1 class="title"><?=$category['title_'.Yii::$app->language]?></h1>
    <div class="map_site">
        <a href="<?=\yii\helpers\Url::to(['site/index'])?>" class="main_page_link"><?=Yii::t("app","Home")?></a>
        <p class="this_page"><i class="fas fa-angle-double-right"><?=$category['title_'.Yii::$app->language]?></i></p>
    </div>
</header>
<section class="rahbariyat">
    <main class="container">
        <div class="rahbariyat_menu col-md-3 col-sm-3">
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
            <?php foreach ($leaders as $leader):?>
            <div class="info_block_persons ">
                <div class="info_block_person">
                    <div class="photo_person col-md-3 col-sm-3">
                        <img class="photo_person_img" src="<?=$leader['rasm']?>" alt="person">
                    </div>
                    <div class="person_info col-md-9 col-sm-9">
                        <h3><?=$leader['position_'.Yii::$app->language]?></h3>
                        <h4><?=$leader['name_'.Yii::$app->language]?></h4>
                        <div class="info">
                            <div class="info_item">
                                <h5><i class="far fa-clock"></i> <?=Yii::t("app","Reception time")?>:</h5>&nbsp;
                                <p><?=$leader['reception_days_'.Yii::$app->language]?></p>
                            </div>
                            <div class="info_item">
                                <h5><i class="fas fa-phone-alt"></i> <?=Yii::t("app","Phone")?>:</h5>&nbsp;
                                <p><?=$leader->phone?></p>
                            </div>
                            <div class="info_item">
                                <h5><i class="far fa-envelope"></i><?=Yii::t("app","Email")?>:</h5>&nbsp;
                                <p><?=$leader->email?></p>
                            </div>
                        </div>
                        <div class="accordion" id="infoBlockAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="vazifalar">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne<?=$leader->id?>" aria-expanded="true" aria-controls="collapseOne<?=$leader->id?>">
                                        <?=Yii::t("app","Functions")?>
                                    </button>
                                </h2>
                                <div id="collapseOne<?=$leader->id?>" class="accordion-collapse collapse" aria-labelledby="vazifalar"
                                     data-bs-parent="#infoBlockAccordion">
                                    <div class="accordion-body">
                                        <?=$leader['activity_'.Yii::$app->language]?>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="bio">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo<?=$leader->id?>" aria-expanded="false" aria-controls="collapseTwo<?=$leader->id?>">
                                        <?=Yii::t("app","Biography")?>
                                    </button>
                                </h2>
                                <div id="collapseTwo<?=$leader->id?>" class="accordion-collapse collapse" aria-labelledby="bio"
                                     data-bs-parent="#infoBlockAccordion">
                                    <div class="accordion-body">
                                      <?=$leader['biography_'.Yii::$app->language]?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>

    </main>
</section>
