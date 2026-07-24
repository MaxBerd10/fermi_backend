<?php
/** @var \backend\models\Course $categories */
$this->title="Dars jadvali"
?>
<style>
    @import url('https://fonts.googleapis.com/css?family=Muli:400,700&display=swap');

    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Muli', sans-serif;
    }

    .wrapper{
        width: 100%;
        margin: 80px auto 0;
        border: 1px solid #333;
        padding: 2px 10px;
    }

    .wrapper .accordion_wrap .accordion_header{
        width: 100%;
        height: 50px;
        background: #000064;
        padding: 15px;
        color: #ffffff;
        font-weight: 700;
        border-bottom: 2px solid #ffffff;
        position: relative;
        cursor: pointer;
    }

    .wrapper .accordion_wrap:first-child .accordion_header{
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
    }

    .wrapper .accordion_wrap:last-child .accordion_header{
        border-bottom: 2px solid transparent;
        border-bottom-left-radius: 3px;
        border-bottom-right-radius: 3px;
    }

    .wrapper .accordion_wrap:last-child .accordion_header:hover{
        border-bottom: 2px solid transparent;
    }

    .wrapper .accordion_wrap .accordion_header:before,
    .wrapper .accordion_wrap .accordion_header:after{
        content: "";
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 15px;
        width: 20px;
        height: 2px;
        background: #000064;
    }

    .wrapper .accordion_wrap .accordion_header:hover{
        color: #ffffff;
        border-color: #ffffff;
    }

    .wrapper .accordion_wrap .accordion_header:hover:before,
    .wrapper .accordion_wrap .accordion_header:hover:after{
        background: #ffffff;
    }

    .wrapper .accordion_wrap .accordion_header:after{
        transform: rotate(-90deg);
        transition: all 0.5s ease;
    }

    .wrapper .accordion_wrap .accordion_body{
        width: 100%;
        height: 0px;
        transition: all 0.5s ease;
        background:white;
        overflow: hidden;
    }

    .wrapper .accordion_wrap .accordion_body p{
        padding: 15px;
        font-size: 15px;
        line-height: 22px;
        color: #1b1c5d;
    }
    .wrapper .accordion_wrap .accordion_header.active{
        color: #ffffff;
        border-color: #ffffff;
    }
    .wrapper .accordion_wrap:last-child .accordion_header.active{
        border-bottom: 2px solid #ffffff;
        border-bottom-left-radius: 0px;
        border-bottom-right-radius: 0px;
    }

    .wrapper .accordion_wrap .accordion_header.active:before,
    .wrapper .accordion_wrap .accordion_header.active:after{
        background: transparent;
        transition: all 0.5s ease;
    }

    .wrapper .accordion_wrap .accordion_header.active:after{
        transform: rotate(0deg);
    }

    .wrapper .accordion_wrap .accordion_header.active + .accordion_body{
        height: 180px;
    }
</style>
<header class="header_section">
    <h1 class="title" style="text-transform:capitalize!important;">Dars Jadvali</h1>
    <div class="map_site">
        <a href="<?=\yii\helpers\Url::to(['site/index'])?>" class="main_page_link"><?=Yii::t("app","Home")?></a>
        <p class="this_page"> <i class="fas fa-angle-double-right">Dars Jadvali</i></p>
    </div>
</header>
<div class="yangilik_lar">
    <div class="container yangiliklar_wrapper">
        <div class="yangiliklar_items row-lg" style="width: 100%">
            <div class="wrapper">
                <?php
                $active=['active','','','','',''];
                 $i=0;
                ?>
                <?php foreach ($categories as $category):?>
                <div class="accordion_wrap accordion_1">
                    <div class="accordion_header <?=$active[$i]?>">
                        <p style="22px"><?=$category['title_'.Yii::$app->language]?></p>
                    </div>
                    <div class="accordion_body <?=$active[$i]?>">
                    <?php foreach ($category->schedules as $schedule):?>
                        <a href="<?=$schedule->file?>" style="color:#1b1c5d;margin-left: 30px;font-size: 22px"><?=$schedule['title_'.Yii::$app->language]?></a><br>
                    <?php endforeach;?>
                    </div>
                    <?php $i++?>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>
<?php
 $js = <<< JS
$(document).ready(function(){
			$(".accordion_header").click(function(){
			   $(".accordion_header").removeClass("active");
			   $(this).addClass("active");
			});
		});
JS;
 $this->registerJs($js);


?>