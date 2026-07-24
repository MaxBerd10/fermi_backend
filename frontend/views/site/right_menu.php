<?php

use backend\modules\menumanager\models\Menu;
$menu = Menu::find()->where(['id' => 4])->one();?>
<?php $submenus = $menu->activeSubMenus?>
<ul class="main-menu__list">
    <li class="active"><a href="#"><?=$menu['title_'.Yii::$app->language]?></a></li>
    <? foreach ($submenus as $submenu): ?>
        <li><a href="<?=$submenu['url']?>"><?=$submenu['title_'.Yii::$app->language]?></a></li>
    <?php  endforeach;?>
</ul>