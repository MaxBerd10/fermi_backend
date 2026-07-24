<?

use backend\models\About;
use backend\models\Counter;
use backend\models\Departments;
use backend\models\Faculty;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Farg'ona jamoat salomatligi tibbiyot insituti";
?>
    <div class="yangilik_lar">
        <div class="container yangiliklar_wrapper">
            <div class="yangiliklar_items owl-carousel row-lg">
                <?php /** @var TYPE_NAME $news */
                foreach ($news as $new):?>
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
                        <div class="yangiliklar_item_info">
                            <a href="<?= Url::to(['site/news', 'id' => $new->category['slug'], 'menu_id' => 71]) ?>"
                               style="color: #333333"
                               class="yangiliklar_item_info_text"><?= $new->category['title_' . Yii::$app->language] ?></a>
                            <?php
                            $newDateString = Yii::$app->formatter->asDate(strtotime($new->date));
                            ?>
                            <p class="yangiliklar_item_date"><i class="far fa-clock"></i><?= $newDateString ?></p>
                        </div>
                        <div class="yangiliklar_item_content">
                            <?php
                            $stringCut = mb_substr(strip_tags($new['title_' . Yii::$app->language]), 0, 30);
                            $endPoint = strrpos($stringCut, ' ');
                            ?>
                            <h3 class="yangiliklar_item_title"><?= $content = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0); ?>
                                ...</h3>
                            <a href="<?= Url::to(['site/detail', 'id' => $new['slug'], 'menu_id' => 71]) ?>"
                               class="yangiliklar_item_text" style="color: #333">

                                <?= Html::decode(mb_substr(strip_tags($new['content_' . Yii::$app->language]), 0, 190)); ?>
                                ...
                            </a>
                        </div>
                        <div class="yangiliklar_item_more">
                            <a href="<?= Url::to(['site/detail', 'id' => $new['slug'], 'menu_id' => 71]) ?>"
                               class="more_info"><?= Yii::t("app", "Read more") ?> <i
                                        class="fas fa-angle-right"></i></a>
                            <p class="info_view"><i class="far fa-eye"></i> <?= $new->seen ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="<?= Url::to(['site/all']) ?>" class="all_news"
               style="text-align: center"><?= Yii::t("app", "All News") ?></a>
        </div>
    </div>
    <!-- Yangiliklar ends -->
    <!-- About us -->
    <section class="about">
        <? $about = About::getAbout() ?>
        <div class="row d-flex align-center">
            <div class="video-content" style=" background-image: url(<?= $about['img'] ?>);">
                <a data-fancybox="single" href="https://www.youtube.com/embed/<?= $about['url'] ?>" class="playBut">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                         xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" width="180px"
                         height="180px" viewBox="0 0 213.7 213.7" enable-background="new 0 0 213.7 213.7"
                         xml:space="preserve">
		                <polygon class="triangle" id="XMLID_18_" fill="none" stroke-width="7" stroke-linecap="round"
                                 stroke-linejoin="round" stroke-miterlimit="10"
                                 points="  73.5,62.5 148.5,105.8 73.5,149.1 "></polygon>
                        <circle class="circle" id="XMLID_17_" fill="none" stroke-width="7" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10" cx="106.8" cy="106.8" r="103.3"></circle>
                </svg>
                </a>
            </div>
            <div class="text-content">
                <?php
                $stringCut = mb_substr(strip_tags($about['title_' . Yii::$app->language]), 0, 85);
                $endPoint = strrpos($stringCut, ' ');
                ?>
                <h2 style="text-align: center;font-size: 20px">
                    <?= $content = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0); ?>...
                </h2>
                <div class="about-body">
                    <?php
                    $stringCut = mb_substr(strip_tags($about['content_' . Yii::$app->language]), 0, 350);
                    $endPoint = strrpos($stringCut, ' ');
                    ?>
                    <?= $content = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0); ?>...

                </div>
                <a href="<?= Url::to(['site/about', 'id' => $about['slug']]) ?>"
                   class="btn_readMore"><?= Yii::t("app", "learn more") ?></a>
                <a href="<?= Url::to(['site/virtual-reception']) ?>"
                   class="btn_borderBlue"><?= Yii::t("app", "Connection") ?></a>
            </div>
        </div>
        <div class="container mt-3">
            <div class="cards res-none">
                <div class="row counter">
                    <?php $counter = Counter::getCounter() ?>
                    <div class="px-0 col-lg-3 col-md-3 col-sm-12">
                        <div class="card-item">
                            <span class="fas fa-user-tie"></span>
                            <div class="count" data-count="<?= $counter['professor_teachers'] ?>">0</div>
                            <h4 class="size15 text-center mt-2"><?= Yii::t("app", "Professors and teachers") ?></h4>
                        </div>
                    </div>
                    <div class="px-0 col-lg-3 col-md-3 col-sm-12">
                        <div class="card-item">
                            <span class="fas fa-users"></span>
                            <div class="count" data-count="<?= $counter['students'] ?>">0</div>
                            <h4 class="size15 text-center mt-2"><?= Yii::t("app", "Students") ?></h4>
                        </div>
                    </div>
                    <div class="px-0 col-lg-3 col-md-3 col-sm-12">
                        <div class="card-item">
                            <span class="fas fa-graduation-cap"></span>
                            <div class="count" data-count="<?= $counter['graduaters'] ?>">0</div>
                            <h4 class="size15 text-center mt-2"><?= Yii::t("app", "Alumni") ?></h4>
                        </div>
                    </div>
                    <div class="px-0 col-lg-3 col-md-3 col-sm-12">
                        <div class="card-item">
                            <span class="fas fa-book"></span>
                            <div class="count" data-count="<?= $counter['book_fund'] ?>">0</div>
                            <h4 class="size15 text-center mt-2"><?= Yii::t("app", "Book fund") ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cards desk-none owl-carousel" id="card-carousel">
                <div class="card-item">
                    <span class="fas fa-user-tie"></span>
                    <div class="counter"><?= $counter['professor_teachers'] ?></div>
                    <h4 class="size15 text-center mt-2"><?= Yii::t("app", "Professors and teachers") ?></h4>
                </div>
                <div class="card-item">
                    <span class="fas fa-users"></span>
                    <div class="counter"><?= $counter['students'] ?></div>
                    <h4 class="size15 text-center mt-2"><?= Yii::t("app", "Students") ?></h4>
                </div>
                <div class="card-item">
                    <span class="fas fa-graduation-cap"></span>
                    <div class="counter"><?= $counter['graduaters'] ?></div>
                    <h4 class="size15 text-center mt-2"><?= Yii::t("app", "Alumni") ?></h4>
                </div>
                <div class="card-item">
                    <span class="fas fa-book"></span>
                    <div class="counter"><?= $counter['book_found'] ?></div>
                    <h4 class="size15 text-center mt-2"><?= Yii::t("app", "Book fund") ?></h4>
                </div>
            </div>
        </div>
    </section>

    <section class="interactive" style="margin-top: 250px">
        <h2 style="text-transform: uppercase;text-align: center;color: #000064;"><?= Yii::t("app", "Interactive services") ?></h2>
        <main class="container">

            <div class="interactive_items">
                <a href="<?= Url::to(['site/virtual-reception']) ?>" class="interactive_item">
                    <img src="/img/1.png" alt="icon1">
                    <h2 class="item_title"
                        style="text-transform: uppercase"><?= Yii::t("app", "Virtual reception") ?></h2>
                </a>
                <a href="http://moodle.fjsti.uz/login/index.php" class="interactive_item">
                    <img src="/img/moodle2.png" alt="icon1">
                    <h2 class="item_title"
                        style="text-transform: uppercase"><?= Yii::t("app", "DISTANCE EDUCATION") ?></h2>
                </a>
                <a href="http://hemis.fjsti.uz" class="interactive_item">
                    <img src="/img/hemisorg.png" alt="icon1">
                    <h2 class="item_title"
                        style="text-transform: uppercase"><?= Yii::t("app", "DISTANCE EDUCATION MANAGEMENT SYSTEM") ?></h2>
                </a>
             
                <a href="https://www.scopus.com/standard/marketing.uri" class="interactive_item">
                    <img src="/img/scopus.jpg" alt="icon1">
                    <h2 class="item_title" style="text-transform: uppercase">Scopus</h2>
                </a>
         <a href="https://doctorium.com/" class="interactive_item">
                    <img src="/img/doctorium.jpg" alt="icon1">
                    <h2 class="item_title" style="text-transform: uppercase">Doctorium</h2>
                </a>
             
            </div>
        </main>
    </section>
    <section class="fakultetlar">
        <div class="container">
            <div class="fak-title">
                <h2 style="text-transform: uppercase;"><?= Yii::t("app", "Faculties") ?></h2>
            </div>
            <div class="w-100 swiper-container mySwiper2">
                <div class="swiper-wrapper">
                    <? $faculties = Faculty::getFaculty() ?>
                    <?php foreach ($faculties as $faculty): ?>
                        <div class="swiper-slide">
                            <div class="card w-100">
                                <div class="card-head">
                                    <div class="overlay-card">
                                        <a href="<?= Url::to(['site/fakultet', 'id' => $faculty['slug'], 'menu_id' => 17]) ?>"
                                           class="btn btn-more"><?= Yii::t("app", "Read more") ?></a>
                                    </div>
                                    <img src="<?= $faculty['img'] ?>" alt="" class="card-img-top">
                                </div>
                            </div>
                            <div class="card-body w-100">
                                <h4 class="text-center"><?= $faculty['title_' . Yii::$app->language] ?></h4>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <div class="container">
        <section class="swiper-container mySwiper2">
            <h2 style="text-transform: uppercase;text-align: center;color: #000064;"><?= Yii::t("app", "Kafedra") ?></h2>
            <div class="swiper-wrapper ">
               <?php
$departments = Departments::find()
    ->select(['slug', 'img', 'title_uz', 'title_ru', 'title_en'])
    ->where(['status' => 1])
    ->asArray()
    ->all();
?>

<?php foreach ($departments as $department): ?>
    <a href="<?= Url::to(['site/kafedra', 'id' => $department['slug'], 'menu_id' => 38]) ?>" class="swiper-slide">
        <img src="<?= $department['img'] ?>" alt="">
        <h3><?= $department['title_' . Yii::$app->language] ?></h3>
    </a>
<?php endforeach; ?>

            </div>
            <div class="swiper-pagination"></div>
        </section>
    </div>

    <div class="media-block" style="margin-top: 80px">
        <div class="container">
            <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a href="#pills-photomedia" role="tab" aria-controls="pills-photomedia" aria-selected="true"
                       class="nav-link active" id="pills-photomedia-tab" data-toggle="pill"
                       style="color: #000064;"><?= Yii::t("app", "Video materials") ?></a>
                </li>
                <li class="nav-item">
                    <a href="#pills-videomedia" role="tab" aria-controls="pills-videomedia" aria-selected="true"
                       class="nav-link" id="pills-videmedia-tab" data-toggle="pill"
                       style="color: #000064;"><?= Yii::t("app", "Photo gallery") ?></a>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active oz " id="pills-photomedia" role="tabpanel"
                     aria-labelledby="pills-photomedia-tab">
                    <div class="newsLinks">
                        <a href="<?= Url::to(['site/video']) ?>"><?= Yii::t("app", "ALL") ?></a>
                    </div>
                    <div class="videoCarousel owl-carousel" id="gallery">
                        <? /** @var TYPE_NAME $videos */ ?>

                        <? foreach ($videos as $video): ?>
                            <? if ($video['video'] != Null): ?>
                                <div class="col-sm-12 col-lg-12" style="height:220px">
                                    <video src="<?= $video['video'] ?>" style="width: 100%" height="100%"
                                           controls="true"></video>
                                </div>
                            <? endif; ?>
                            <? if ($video['url'] != Null): ?>
                                <div class="col-sm-12 col-lg-12" style="height: 220px">
                                    <iframe width="100%" height="100%"
                                            src="https://www.youtube.com/embed/<?= $video['url'] ?>" allowfullscreen>
                                    </iframe>
                                </div>
                            <? endif; ?>
                        <? endforeach; ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-videomedia" role="tabpanel" aria-labelledby="pills-videomedia-tab">
                    <div class="newsLinks">
                        <a href="<?= Url::to(['site/gallery']) ?>"><?= Yii::t("app", "ALL") ?></a>
                    </div>
                    <div class="PhotoCarousel owl-carousel" id="gallery2">
                        <? /** @var TYPE_NAME $images */ ?>
                        <? foreach ($images as $image): ?>
                            <div class="col-lg-12">
                                <figure style="height: 250px">
                                    <a href="<?= $image['img'] ?>" data-fancybox="fig">
                                        <img src="<?= $image['img'] ?>"
                                             style="height: 100%;width: 100%;object-fit: cover" alt="Picture"/>
                                    </a>
                                    <figcaption style="display: none">
                                        <a href="<?= Url::to(['site/full-gallery', 'id' => $image['slug']]) ?>"><?= $image['title_' . Yii::$app->language] ?></a>.
                                    </figcaption>
                                </figure>
                            </div>

                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$js = <<< JS
 $('[data-fancybox="fig"]').fancybox({
    caption : function(instance,item) {
      return $(this).closest('figure').find('figcaption').html();
    }
  });
JS;
$this->registerJs($js);
