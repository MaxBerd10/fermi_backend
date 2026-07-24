<?php



/* @var $this \yii\web\View */
/* @var $provider \yii\data\ActiveDataProvider */
/* @var $search2 array|\backend\models\Page[]|\yii\db\ActiveRecord[] */

use yii\widgets\LinkPager;

?>
<div class="yangilik_lar">
    <div class="container yangiliklar_wrapper">
        <? $news=$provider->getModels()?>
        <? if (count($news)>0):?>
            <div class="yangiliklar_items row-lg">
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
        <?php else:?>
        <h2 style="text-align: center">Ma'lumot topilmadi</h2>
    <?php endif;?>
    </div>
</div>
<div class="container">
    <div class="row" style="margin-top: 20px;display: flex;align-items: start">
        <ul>
            <?if(count($search2)):?>
                <h2 class="title">Sahifalar</h2>
                <?foreach ($search2 as $value ):?>
                    <li><a href="<?=\yii\helpers\Url::to(['site/page','id'=>$value['slug']])?>" style="color: #1b1c5d;"><?=$value['title_'.Yii::$app->language]?></a></li>
                <?endforeach;?>
            <?endif;?>
        </ul>
    </div>
</div>