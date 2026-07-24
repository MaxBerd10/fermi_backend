<?php
/** @var TYPE_NAME $page */
/** @var TYPE_NAME $menu */
/** @var TYPE_NAME $provider */
/** @var TYPE_NAME $category */


use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title=$category['title_'.Yii::$app->language]
?>
<header class="header_section">
    <h1 class="title" style="text-transform: uppercase"><?=$category['title_'.Yii::$app->language]?></h1>
    <div class="map_site">
        <a href="<?=\yii\helpers\Url::to(['site/index'])?>" class="main_page_link"><?=Yii::t("app","Home")?></a>
        <p class="this_page"> <i class="fas fa-angle-double-right"></i><?=$category['title_'.Yii::$app->language]?></p>
    </div>
</header>
    <div class="yangilik_lar">
        <div class="container yangiliklar_wrapper">
            <div class="yangiliklar_items row-lg">
                <? $news=$provider->getModels()?>
                <?php foreach ($news as $new):?>
                    <div class="yangiliklar_item item  col-lg-3  col-md-3 .container-fluid">
                        <div class="item_img">
                            <?
                            preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $new['content_' . Yii::$app->language], $result);
                            ?>
                            <? if ($new['img']== Null): ?>
                                <img src="<?= $result[1] ?>">
                            <?php else: ?>
                                <img src="<?= $new['img'] ?>">
                            <?php endif; ?>
                        </div>
                        <div class="yangiliklar_item_info d-flex flex-column g-2">
                            <a  href="<?=\yii\helpers\Url::to(['site/news','id'=>$new->category['slug'],'menu_id'=>71])?>" style="color: #333333;" class="yangiliklar_item_info_text"><?=$category['title_'.Yii::$app->language]?></a>
                            <?php
                            $newDate = Yii::$app->formatter->asDate(strtotime($new['date']));
                            ?>
                            <p class="yangiliklar_item_date"> <i class="far fa-clock"></i><?=$newDate?></p>
                        </div>
                        <div class="yangiliklar_item_content">
                            <?php
                            $stringCut = mb_substr(strip_tags($new['title_'.Yii::$app->language]), 0, 30);
                            $endPoint = strrpos($stringCut, ' ');
                            ?>
                            <h3 class="yangiliklar_item_title"><?= $content = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);?>...</h3>
                            <a href="<?=\yii\helpers\Url::to(['site/detail','id'=>$new['slug'],'menu_id'=>71])?>" class="yangiliklar_item_text" style="color: #333">

                                <?= Html::decode(mb_substr(strip_tags($new['content_'.Yii::$app->language]),0,190));?>...
                            </a>
                        </div>
                        <div class="yangiliklar_item_more">
                            <a href="<?=\yii\helpers\Url::to(['site/detail','id'=>$new['slug'],'menu_id'=>71])?>" class="more_info">Batafsil <i class="fas fa-angle-right"></i></a>
                            <p class="info_view"><i class="far fa-eye"></i> <?=$new['seen']?></p>
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

<?php
