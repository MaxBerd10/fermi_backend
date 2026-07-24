<?php



/* @var $this \yii\web\View */
/* @var $corusel array|\backend\models\Corusel|null|\yii\db\ActiveRecord */
/* @var $menus array|\backend\models\Corusel|null|\yii\db\ActiveRecord */
$this->title=Yii::t("app","News")

?>

<style>
    #page img{
        width: 100%!important;
        height: auto!important;
        margin-bottom: 10px!important;
    }
</style>
<header class="header_section">
    <?
    $stringCut = substr(strip_tags($corusel['title_'.Yii::$app->language]), 0, 70);
    $endPoint = strrpos($stringCut, ' ');
    ?>
    <h1 class="title"><?    echo $content = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0); ?>...</h1>
    <div class="map_site">
        <a href="<?=\yii\helpers\Url::to(['site/index'])?>" class="main_page_link"><?=Yii::t("app","Home")?></a>
    </div>
</header>
<section class="page-content pb-5">
    <div class="page-content-section py-4">
        <div class="container ">
            <div class="row">
                <div class="col-lg-8" id="page">
                    <h2 style="text-align: center;font-weight:bold; color: #118A1E"><?=$corusel['title_'.Yii::$app->language]?></h2>
                    <?=$corusel['content_'.Yii::$app->language]?>
                </div>
                <div class="col-lg-4 sidebar">
                    <ul class="main-menu__list">
                        <li class="active"><a href="#"><?=$menus['title_'.Yii::$app->language]?></a></li>
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
