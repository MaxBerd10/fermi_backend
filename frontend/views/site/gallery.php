<?php
/** @var TYPE_NAME $page */
/** @var TYPE_NAME $menu */
/** @var TYPE_NAME $provider */

use yii\widgets\LinkPager;

$this->title=Yii::t("app","GALLERY");
?>
    <header class="header_section">
        <h1 class="title"><?=Yii::t("app","Photo gallery")?></h1>
        <div class="map_site">
            <a href="<?=\yii\helpers\Url::to(['site/index'])?>" class="main_page_link"><?=Yii::t("app","Home")?></a>
            <p class="this_page"> <i class="fas fa-angle-double-right"></i><?=Yii::t("app","Photo gallery")?></p>
        </div>
    </header>
    <section class="page-content pb-5">
        <div class="page-content-section py-4">
            <div class="container ">
                <div class="row">
                    <? $images=$provider->getModels()?>
                    <? foreach ($images as $image):?>
                        <div class="col-lg-4 col-sm-12">
                            <figure style="height: 220px">
                                <a href="<?=$image['img']?>" data-fancybox="fig">
                                    <img src="<?=$image['img']?>" style="height: 100%; width: 100%;object-fit: cover" class="img-fluid" alt="Picture" />
                                </a>
                                <figcaption style="display: none" >
                                    <a href="<?=\yii\helpers\Url::to(['site/full-gallery','id'=>$image['slug']])?>"><?=$image['title_'.Yii::$app->language]?></a>.
                                </figcaption>
                            </figure>
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
    </section>
<?php
$js = <<< JS
 $('[data-fancybox="fig"]').fancybox({
    caption : function(instance,item) {
      return $(this).closest('figure').find('figcaption').html();
    }
  });
JS;
$this->registerJs($js);

?>