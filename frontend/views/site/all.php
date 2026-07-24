<?php



/* @var $this \yii\web\View */
/* @var $provider \yii\data\ActiveDataProvider */

use yii\widgets\LinkPager;

?>
<header class="header_section">
    <h1 class="title" style="text-transform: uppercase"><?=Yii::t("app","News")?></h1>
    <div class="map_site">
        <a href="<?=\yii\helpers\Url::to(['site/index'])?>" class="main_page_link"><?=Yii::t("app","Home")?></a>
        <p class="this_page"> <i class="fas fa-angle-double-right"></i><?=Yii::t("app","News")?></p>
    </div>
</header>
<div class="yangilik_lar">
    <div class="container yangiliklar_wrapper">
        <div class="yangiliklar_items row-lg">
            <? $news=$provider->getModels()?>
            <?php foreach ($news as $new):?>
                <div class="yangiliklar_item  col-lg-4  col-md-4 .container-fluid">
                    <div class="item_img">
                        <?
                        preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $new['content_' . Yii::$app->language], $result);
                        ?>
                        <? if ($result!=Null): ?>
                            <img src="<?=$result[1]?>">
                        <?php endif;?>
                    </div>
                    <div class="yangiliklar_item_info">
                        <p class="yangiliklar_item_info_text"><?=$new->category['title_'.Yii::$app->language]?></p>
                        <?php
                        $orgDate = $new->date;
                        $newDate = date("d:m:Y", strtotime($orgDate));
                        ?>
                        <p class="yangiliklar_item_date"> <i class="far fa-clock"></i><?=$newDate?></p>
                    </div>
                    <div class="yangiliklar_item_content">
                        <?php
                        $stringCut = mb_substr(strip_tags($new['title_'.Yii::$app->language]), 0, 50);
                        $endPoint = strrpos($stringCut, ' ');
                        ?>
                        <h3 class="yangiliklar_item_title"><?= $content = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);?>...</h3>
                        <p class="yangiliklar_item_text">
                            <?php
                            $stringCut = mb_substr(strip_tags($new['content_'.Yii::$app->language]), 0, 250);
                            $endPoint = strrpos($stringCut, ' ');
                            ?>
                            <?= $content = $endPoint? substr($stringCut, 0, $endPoint) : mb_substr($stringCut, 0);?>...
                        </p>
                    </div>
                    <div class="yangiliklar_item_more">
                        <a href="<?=\yii\helpers\Url::to(['site/detail','id'=>$new['slug'],'menu_id'=>71])?>" class="more_info">Batafsil <i class="fas fa-angle-right"></i></a>
                        <p class="info_view"><i class="far fa-eye"></i> <?=$new->seen?></p>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
        <?php
        echo LinkPager::widget([
            'pagination' => $provider->pagination,
            'options' => ['class' => 'pagination'],
            'linkOptions' => ['class' => 'page-item'],
            'activePageCssClass' => 'p-active',
        ]);
        ?>
    </div>
</div>
