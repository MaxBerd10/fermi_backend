<?php



/* @var $this \yii\web\View */
/* @var $fullgallery array|\backend\models\Img|null|\yii\db\ActiveRecord */
/* @var $menus array|\backend\modules\menumanager\models\Menu|null|\yii\db\ActiveRecord */
?>
<style>
    #galleryy img{
        width: 100%!important;
        height: auto!important;
        margin-bottom: 10px!important;
    }
</style>
<section class="page-content pb-5">
    <div class="page-content-section py-4">
        <div class="container ">
            <div class="row">
                <div class="col-lg-8" id="galleryy">
                    <h2 style="text-align: center;font-weight:bold;z"><?=$fullgallery['title_'.Yii::$app->language]?></h2>
                    <?=$fullgallery['content_'.Yii::$app->language]?>
                </div>
                <div class="col-lg-4 sidebar">
                    <ul class="main-menu__list">
                        <li class="active"><a href="/news"><?=$menus['title_'.Yii::$app->language]?></a></li>
                        <?$submenus=$menus->activeSubMenus?>
                        <?php foreach ($submenus as $submenu):?>
                            <li><a href="<?=$submenu->getUrl(['menu_id' => $menus->id ]) ?>"><?=$submenu['title_'.Yii::$app->language]?></a></li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

