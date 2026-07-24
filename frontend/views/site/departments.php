<?php



/* @var $this \yii\web\View */
/* @var $departments array|\backend\models\Departments|null|\yii\db\ActiveRecord */
/* @var $menus array|\backend\modules\menumanager\models\Menu|null|\yii\db\ActiveRecord */
?>
<header class="header_section">
    <h1 class="title" style="max-width: 500px;text-align: center;color: white!important;"><?=$departments['title_'.Yii::$app->language]?></h1>
    <div class="map_site">
        <a href="<?=\yii\helpers\Url::to(['site/index'])?>" class="main_page_link"><?=Yii::t("app","Home")?></a>
        <p class="this_page" style="max-width: 540px"> <i class="fas fa-angle-double-right"></i><?=$departments['title_'.Yii::$app->language]?></p>
    </div>
</header>
<section class="page-content pb-5">
    <div class="page-content-section py-4">
        <div class="container ">
            <div class="row">
                <div class="col-lg-8">
                    <h2 style="text-align: center;font-weight:bold;"><?=$departments['title_'.Yii::$app->language]?></h2>
                    <?=$departments['content_'.Yii::$app->language]?>
                </div>
                <div class="col-lg-4 sidebar">
                    <ul class="main-menu__list">
                        <li class="active"><a href="/news"><?=$menus['title_'.Yii::$app->language]?></a></li>
                        <?$submenus=$menus->subMenus?>
                        <?php foreach ($submenus as $submenu):?>
                            <li><a href="<?=$submenu->getUrl(['menu_id' => $menus->id ]) ?>"><?=$submenu['title_'.Yii::$app->language]?></a>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if($leaders!=Null):?>
    <section class="rahbariyat" style="margin-top: -60px">
        <main class="container">
            <div class="rahbariyat_menu col-md-3 col-sm-3">
            </div>
            <div class="info_block col-md-9 col-sm-9">
                <?php foreach ($leaders as $leader):?>
                    <div class="info_block_persons ">
                        <div class="info_block_person">
                            <div class="photo_person col-md-3 col-sm-3" style="border: none !important; width: 230px !important; height: 230px !important;" >
                                <img class="photo_person_img" src="<?=$leader['rasm']?$leader['rasm']:'@frontend/web/avatar.jpg'?>" alt="person" style="object-fit:cover !important;width: 100% !important;height: 100% !important;object-position: center !important;  ">
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
<?php endif;?>