<style>

    .toggle {
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
        display: block;
        color: #000080!important;
        font-weight: bold;
        position: relative;
        padding-left: 30px;
        padding-right: 50px;

    }
    .toggle::before {
        position: absolute;
        left: 0;
        font-size: 15px;
        counter-increment: sana;
        content: counter(sana) ".";
    }
    .toggle::after {
        position: absolute;
        right: 0;
        top: 0;
        margin: 18px;
        content: "+";
        font-size: 24px;
        line-height: 1;
    }
    .toggle.active ~ .panel{
        overflow: hidden;
        animation: toggleActive 1s ease-in-out forwards;
    }
    @keyframes toggleActive {
        from {
            height: 0;
        }
        to {
            height: auto;
        }
    }
    .panel-item {
        padding: 0 18px;
        display: none;
        background-color: white;
        overflow: hidden;
    }

</style>
<?php
$this->title=$menus['title_'.Yii::$app->language];
?>
<header class="header_section">
    <h1 class="title"><?=$menus['title_'.Yii::$app->language]?></h1>
    <div class="map_site">
        <a href="<?=\yii\helpers\Url::to(['site/index'])?>" class="main_page_link"><?=Yii::t("app","Home")?></a>
        <p class="this_page"> <i class="fas fa-angle-double-right"></i><?=$menus['title_'.Yii::$app->language]?></p>
    </div>
</header>
<section class="page-content pb-5">
    <div class="page-content-section py-4">
        <div class="container ">
            <div class="row">
                <div class="col-lg-8">
                    <? /** @var TYPE_NAME $documents_items */
                    foreach ($documents_items as $value):?>
                        <a class="toggle" style="color: #000064!important;"><?=$value['title_'.Yii::$app->language]?></a>
                        <div class="panel-item">
                            <p><?=$value['content_'.Yii::$app->language]?></p>
                        </div>
                        <div class="clearfix"></div>
                    <?endforeach;?>
                </div>
                <div class="col-lg-4 sidebar">
                    <ul class="main-menu__list">
                        <li class="active"><a href="#"><?=$menus['title_'.Yii::$app->language]?></a></li>
                        <?$submenus=$menus->activeSubMenus?>
                        <?php foreach ($submenus as $submenu):?>
                        <li><a href="<?=$submenu->getUrl(['menu_id' => $submenu->id ]) ?>"><?=$submenu['title_'.Yii::$app->language]?></a></li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$js = <<<JS
var acc = document.getElementsByClassName("toggle");
    var i;
    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
JS;
$this->registerJs($js);

?>