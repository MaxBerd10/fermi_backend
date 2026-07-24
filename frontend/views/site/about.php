<?php
/* @var $this \yii\web\View */
/* @var $news array|\backend\models\Post|null|\yii\db\ActiveRecord */
$this->title=Yii::t("app","News")
?>
<header class="header_section">
    <h1 class="title"><?=Yii::t("app","about Us")?></h1>
    <div class="map_site">
        <a href="<?=\yii\helpers\Url::to(['site/index'])?>" class="main_page_link"><?=Yii::t("app","Home")?></a>
        <p class="this_page"> <i class="fas fa-angle-double-right"></i><?=Yii::t("app","about Us")?></p>
    </div>
</header>
<section class="page-content pb-5">
    <div class="page-content-section py-4">
        <div class="container ">
            <div class="row">
                <div class="col-lg-8">
                    <h2 style="text-align: center;font-weight:bold;z"><?=$news['title_'.Yii::$app->language]?></h2>
                    <?=$news['content_'.Yii::$app->language]?>
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
