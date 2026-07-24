<?php

$this->title=Yii::t("app","	Virtual reception");
$this->params['breadcrumbs'][] = ['label' =>Yii::t("app","	Virtual reception")];
$this->params['content']=Yii::t("app","	Virtual reception");

?>
<div class="top-nav">
    <div class="container">
        <div class="top-nav_menu">
            <div class="top-nav__info_block">
                <ul class="top-nav__ul" >
                    <li class="eyeblock">
                        <a href="#" class="eyeblock_title"><?=Yii::t("app","Special facilities")?></a>
                        <div class="dropDown">
                            <h6>Ko'rinish</h6>
                            <div class="viewBlock">
                                <a href="#" class="blue">A</a>
                                <a href="#" class="grey">A</a>
                                <a href="#" class="black">A</a>
                            </div>
                            <h6><?=Yii::t("app","Font size")?></h6>
                            <p><span class="fontRange">0</span>%<?=Yii::t("app","enlarge")?></p>
                            <div class="slidecontainer">
                                <input type="range" min="0" max="10" value="0" step="1" class="slider" id="fontRange">
                            </div>
                            <h6><?=Yii::t("app","Appearance size")?></h6>
                            <p><span class="viewRange">0</span>% <?=Yii::t("app","enlarge")?></p>
                            <div class="slidecontainer">
                                <input type="range" min="0" max="100" step="10" value="1" class="slider" id="viewRange">
                            </div>
                            <a href="#" id="resetAll"><?=Yii::t("app","Go to the full version of the site")?></a>
                        </div>
                    </li>
                    <li class="other_links">
                        <ul class="sub_ul">
                            <li><a href="<?=\yii\helpers\Url::to(['site/page','id'=>'ozbekiston-respublikasi-davlat-bayrogi','menu_id'=>71])?>"><img src="/img/png/gerb.png" alt="davlat gerbi"></a></li>
                            <li><a href="<?=\yii\helpers\Url::to(['site/page','id'=>'ozbekiston-respublikasining-davlat-gerbi','menu_id'=>71])?>"><img src="/img/flags/uzbFlag.svg" alt="davlat bayrogi"></a></li>
                            <li><a href="<?=\yii\helpers\Url::to(['site/page','id'=>'ozbekiston-respublikasining-davlat-madhiyasi','menu_id'=>71])?>"><i class="fas fa-music"></i></a></li>
                            <li><a href="<?=\yii\helpers\Url::to(['site/sitemap'])?>"><i class="fas fa-sitemap"></i></a></li>
                        </ul>
                    </li>
                </ul>

                <a href="<?=\yii\helpers\Url::to(['site/virtual-reception'])?>" class="top-nav_langs_virt_btn"><?=Yii::t("app","Virtual reception")?></a>
                <div class="header_top_social">
                    <ul class="header__top_social">
                        <?php foreach ($networks as $network): ?>
                            <li class="header__top_li">
                                <a href="<?=$network['url']?>" class="header__top_link" title="<?=$network['titlte']?>">
                                    <i class="fab fa-<?=$network['icon']?>"></i>
                                </a>
                            </li>
                        <?php endforeach;?>
                        <li  class="header__top_li">
                            <a href="http://webmail.fjsti.uz" class="header__top_link" title="webmail" ><i class="fal fa-envelope"></i></a>
                        </li>
                    </ul>
                </div>
                <form class="header__top_search" method="get" action="<?=\yii\helpers\Url::to(['site/search'])?>">
                    <button href="#" style="border: 0;background: white;float: right"><i class="fas fa-search"></i></button>
                    <input type="search" placeholder="<?=Yii::t("app","Search")?>" name="search" >
                </form>
                <div class="top-nav_langs">
                    <?php if (Yii::$app->language=='uz'):?>
                        <span class="selected_lang" data-lang="oz"><img src="/img/flags/uzbFlag.svg" alt="uz"> O'zbekcha<i
                                    class="fa fa-angle-down"></i>
								<ul class="top-nav_langs_switch">
									<a class="ru" href="<?=\yii\helpers\Url::to(['site/change','til'=>'ru'])?>"> <img src="/img/flags/ru.png" alt="ru"> Русский</a>
									<a class="en" href="<?=\yii\helpers\Url::to(['site/change','til'=>'en'])?>"> <img src="/img/flags/en.png" alt="eng"> English</a>
								</ul>
							</span>
                    <?php endif;?>
                    <?php if (Yii::$app->language=='ru'):?>
                        <span class="selected_lang" data-lang="oz"><img src="/img/flags/ru.png" alt="ru"> Русский<i
                                    class="fa fa-angle-down"></i>
								<ul class="top-nav_langs_switch">
									<a class="ru" href="<?=\yii\helpers\Url::to(['site/change','til'=>'uz'])?>"> <img src="/img/flags/uzbFlag.svg" alt="uz"> O'zbekcha</a>
									<a class="en" href="<?=\yii\helpers\Url::to(['site/change','til'=>'en'])?>"> <img src="/img/flags/en.png" alt="eng"> English</a>
								</ul>
							</span>
                    <?php endif;?>
                    <?php if (Yii::$app->language=='en'):?>
                        <span class="selected_lang" data-lang="oz"><img src="/img/flags/ru.png" alt="ru"> English<i
                                    class="fa fa-angle-down"></i>
								<ul class="top-nav_langs_switch">
									<a class="uz" href="<?=\yii\helpers\Url::to(['site/change','til'=>'uz'])?>"> <img src="/img/flags/uzbFlag.svg" alt="uz"> O'zbekcha</a>
									<a class="ru" href="<?=\yii\helpers\Url::to(['site/change','til'=>'ru'])?>"> <img src="/img/flags/ru.png" alt="ru"> Русский</a>
								</ul>
							</span>
                    <?php endif;?>

                </div>

            </div>
        </div>
    </div>
</div>
<div class="header_top">
    <div class="container">
        <div class="header_top_items">
            <div class="header_top_logo">
                <a class="header_top_logo_link" href="<?=\yii\helpers\Url::to(['site/index'])?>">
                    <img class="header_top_logo_img" src="<?=$logo['img']?>" alt="sayt logosi">
                    <h1 class="header_top_logo_text" style="text-transform: uppercase;color: #000064"><?=$logo['title_'.Yii::$app->language]?></h1>
                </a>
            </div>
            <div class="header_top_info">
                <div class="header_top_info_item" style="max-width: 165px">
                    <i class="fas fa-phone-alt"></i>
                    <div class="header_top_info_item_text">
                        <h2><?=$setting['phone']?></h2>
                    </div>
                </div>
                <div class="header_top_info_item" style="max-width: 200px">
                    <i class="far fa-envelope"></i>
                    <div class="header_top_info_item_text">
                        <h2><?=$setting['email']?></h2>
                    </div>
                </div>
                <div class="header_top_info_item">
                    <i class="far fa-clock"></i>
                    <div class="header_top_info_item_text">
                        <p><?=Yii::t("app","working hours")?>:</p>
                        <h2><?=Yii::t("app","Monday-Satur, 9: 0017: 00")?></h2>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="header_dropdown_navbar">
    <div class="container">
        <nav class="navbar navbar-expand-lg">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav"
                    aria-expanded="false" aria-label="Toggle navigation">
                <i class="toggle_icon fas fa-bars"></i>
                <i class="fas fa-times"></i>
            </button>

            <div class="collapse navbar-collapse" id="main_nav">
                <ul class="navbar-nav mx-auto">
                    <?php /** @var TYPE_NAME $menus */
                    foreach ($menus as $menu):
                        $submenus=$menu->activeSubMenus;
                        ?>
                        <?php if ($submenus==Null):?>
                        <li class="nav-item "> <a class="nav-link" href="#"><?=$menu['title_'.Yii::$app->language]?> </a> </li>
                    <?php else:?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle show" href="#" data-bs-toggle="dropdown" style="color: #ffffff!important;font-size: 18px!important;"><?=$menu['title_'.Yii::$app->language]?> </a>
                            <ul class="dropdown-menu">
                                <?php foreach ($submenus as $submenu):?>
                                    <?php $insubmenus=$submenu->activeSubMenus;?>
                                    <?php if ($insubmenus==Null):?>
                                        <li><a class="dropdown-item" href="<?=$submenu->getUrl(['menu_id'=>$menu->id])?>"> <?=$submenu['title_'.Yii::$app->language]?> </a></li>
                                    <?php else:?>
                                        <li><a class="dropdown-item" href="#" style="font-size: 18px;display: flex;flex-direction: row;justify-content: space-between;align-items: center;"> &nbsp; <?=$submenu['title_'.Yii::$app->language]?>&nbsp;&nbsp;&nbsp;<i style="font-weight:normal;" class="fas fa-angle-right"></i> </a>
                                            <ul class="submenu dropdown-menu">
                                                <?php foreach ($insubmenus as $insubmenu):?>
                                                    <li><a class="dropdown-item" href="<?=$insubmenu->getUrl(['menu_id'=>$submenu->id])?>"><?=$insubmenu['title_'.Yii::$app->language]?></a></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </li>
                                    <?php endif;?>
                                <?php endforeach;?>
                            </ul>
                        </li>
                    <?php endif;?>
                    <?php endforeach;?>
                </ul >
                <ul class="my-navbar">
                    <?php /** @var TYPE_NAME $menus */
                    foreach ($menus as $menu):
                    $submenus=$menu->activeSubMenus;
                    ?>
                        <?php if (!empty($submenus)):?>
                        <li class="nav-item my-acardion">
                        <a class="nav-link accordion-item-header" ><?=$menu->title?><i style="font-weight:normal;" class="fas fa-angle-right"></i></a>
                        <ul class="my-menu accordion-item-body">
                            <?php foreach ($submenus as $submenu):?>
                                <?php $insubmenus=$submenu->activeSubMenus;?>
                                <?php if (!empty($insubmenus)):?>
                            <li>
                                <div class="my-acardion">
                                    <a class="my-nav-link accordion-item-header"><?=$submenu->title?><i style="font-weight:normal;" class="fas fa-angle-right"></i> </a>
                                    <ul class="my-menu accordion-item-body">
                                        <?php foreach ($insubmenus as $insubmenu):?>
                                        <li>
                                            <a class=" my-nav-link my-item" href="<?=$insubmenu->getUrl(['menu_id'=>$submenu->id])?>"><?=$insubmenu->title?></a>
                                        </li>
                                        <?php endforeach;?>
                                    </ul>
                                </div>
                            </li>
                                <?php else:?>
                                    <li>
                                        <a class=" my-nav-link my-item" <?=$submenu->getUrl(['menu_id'=>$menu->id])?>><?=$submenu->title?></a>
                                    </li>
                            <?php endif;?>
                            <?php endforeach;?>
                        </ul>
                        </li>
                    <?php else:?>
                        <li class="nav-item my-acardion">
                        <a class="nav-link accordion-item-header" href="<?=$menu->getUrl()?>"><?=$menu->title?></a>
                        </li>
                    <?php endif;?>
                    <?php endforeach;?>
                </ul >

            </div> <!-- navbar-collapse.// -->
        </nav>

    </div>
</div>