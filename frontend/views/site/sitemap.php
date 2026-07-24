<?php



/* @var $this \yii\web\View */
/* @var $category array|\backend\modules\menumanager\models\Menu[]|\yii\db\ActiveRecord[] */
/* @var $menu array|\backend\modules\menumanager\models\Menu[]|\yii\db\ActiveRecord[] */
$this->title=Yii::t("app","Site map")
?>
<header class="header_section">
    <h1 class="title"><?=Yii::t("app","Site map")?></h1>
    <div class="map_site">
        <a href="<?=\yii\helpers\Url::to(['site/index'])?>" class="main_page_link"><?=Yii::t("app","Home")?></a>
        <p class="this_page"> <i class="fas fa-angle-double-right"></i><?=Yii::t("app","Site map")?></p>
    </div>
</header>
<section class="page-content pb-5">
    <div class="page-content-section py-4">
        <div class="container ">
            <div class="row" style=" box-shadow: 1px 1px 3px 1px #ccc;">
                <div class="col-lg-8">
                    <ul style="margin-top: 15px">
                        <? foreach ($category as $category_iteam):?>
                            <li >
                                <? if (($category_iteam['url_type']=='c-action')||($category_iteam['url_type']=='other')): ?>
                                    <a href="/<?=$category_iteam['url_value']?>" >-<?=$category_iteam['title_'.Yii::$app->language]?></a>
                                <?endif;?>
                                <?php $subMenus =$category_iteam->activeSubMenus; ?>
                                <?php if (!empty($subMenus)): ?>
                                    <ul>
                                        <?php foreach ($subMenus as $subMenu):?>
                                            <li style="margin-left: 20px" >
                                                    <a href="<?=$subMenu->getUrl(['menu_id'=>$subMenu->id])?>">--<?=$subMenu['title_'.Yii::$app->language]?></a>
                                                <?$insubmenus=$subMenu->activeSubMenus?>
                                                <?php foreach ($insubmenus as $insubmenu):?>
                                                    <ul>
                                                        <li style="margin-left: 20px"><a href="<?=$insubmenu->getUrl(['menu_id'=>$subMenu->id])?>">---<?=$insubmenu['title_uz']?></a></li>
                                                    </ul>
                                                <?php endforeach;?>
                                            </li>
                                        <?endforeach;?>
                                    </ul>
                                <?endif;?>
                            </li>
                        <?endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

