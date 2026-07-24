<?php
/** @var TYPE_NAME $page */
/** @var TYPE_NAME $menu */
/** @var TYPE_NAME $provider */

use yii\widgets\LinkPager;

$this->title=Yii::t("app","video");

?>
<header class="header_section">
    <h1 class="title" style="text-transform: uppercase"><?=Yii::t("app","video")?></h1>
    <div class="map_site">
        <a href="<?=\yii\helpers\Url::to(['site/index'])?>" class="main_page_link"><?=Yii::t("app","Home")?></a>
        <p class="this_page"> <i class="fas fa-angle-double-right"></i><?=Yii::t("app","video")?></p>
    </div>
</header>
    <section class="page-content pb-5">
        <div class="page-content-section py-4">
            <div class="container ">
                <div class="row">
                    <? /** @var TYPE_NAME $provider */
                    $videos=$provider->getModels()?>
                    <? foreach ($videos as $video): ?>
                        <? if ($video['video']!=Null):?>
                            <div class="col-sm-12 col-md-4" style="height:205px">
                                <video src="<?=$video['video']?>" style="width: 100%"  height="100%" controls="true"></video>
                            </div>
                        <?endif;?>
                        <? if ($video['url']!=Null):?>
                            <div class="col-sm-12 col-md-4" style="height: 230px;margin: 0px">
                                <div id="container">
                                    <iframe width="100%" height="208px" src="https://www.youtube.com/embed/<?=$video['url']?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>                  <div>
                                    </div>
                                    <div class="error"></div>
                                </div>
                            </div>
                        <?endif;?>
                    <?endforeach;?>

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
    </section>