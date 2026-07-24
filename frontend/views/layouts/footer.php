<section class="usefull ">
    <div class="container">
        <h2 class="py-2" style="color: #000064"><?=Yii::t("app","Useful resources")?></h2>
        <div class="owl-carousel" id="use-carousel">
            <?php $usefuls=\backend\models\UsefulSites::find()->where(['status'=>1])->orderBy('id DESC')->asArray()->all()?>
            <?php foreach ($usefuls as $useful):?>
            <a href="<?=$useful['url']?>" class="use-item">
                <img src="<?=$useful['img']?>" alt="">
                <h3 style="color: #000064"><?=$useful['title_'.Yii::$app->language]?></h3>
            </a>
            <?php endforeach;?>
        </div>
    </div>
</section>
<section class="footer">
    <div class="container row">
        <div class="left col-12 col-md-6 col-lg-6 col-xl-6  p-2">
            <div class="header_top_logo">
                <a class="header_top_logo_link" href="<?=\yii\helpers\Url::to(['site/index'])?>">
                    <img class="header_top_logo_img" src="<?=$logo['img']?>" alt="sayt logosi">
                    <h1 class="header_top_logo_text"><?=$logo['title_'.Yii::$app->language]?></h1>
                </a>
            </div>
            <p style="color:white">Sayt materiallaridan foydalanganda, Farg`ona jamoat salomatligi tibbiyot instituti rasmiy web saytiga havola ko'rsatilishi shart
Diqqat! Agar siz matnda xatoliklarni aniqlasangiz, ularni belgilab, ma`muriyatni xabardor qilish uchun Ctrl+Enter tugmalarini bosing yoki sayt adminiga yuboring.</p>
            <div class="contacts">
                <div class="contacts_info">
                    <ul class="foot-address">
                        <li>
                            <img src="/img/svg/call.svg" alt="">
                            <a href="tel:<?= /** @var TYPE_NAME $setting */
                            $setting['phone']?>"><?=$setting['phone']?></a>
                        </li>
                        <li>
                            <img src="/img/svg/sms.svg" alt=""><a href="mailto:<?=$setting['email']?>"><?=$setting['email']?></a>
                        </li>
                        <li>
                            <img src="/img/svg/mappin.svg" alt=""><a href="#!"><?=$setting['address_'.Yii::$app->language]?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="right col-12 col-md-6 col-lg-6 col-xl-6  p-2">
            <div class=" footer_map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1236.689720883338!2d71.8089087!3d40.3802946!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38bb8546725ec125%3A0xcae07b9c0d192cc6!2s!5e1!3m2!1sru!2s!4v1622297016994!5m2!1sru!2s" width="600" height="450" style="border:0;" allowfullscreen=""></iframe>
            </div>
            <div class="header_top_social">
                <ul class="header__top_social">
                    <?php foreach ($networks as $network):?>
                    <li class="header__top_li">
                        <a href="<?=$network['url']?>" class="header__top_link" title="Facebook">
                            <i class="fab fa-<?=$network['icon']?>"></i> <?=$network['titlte']?>
                        </a>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer__info">
        <div class="container">
            <p><a href="https://isoftware.uz/" style="color: #ffffff80!important;">&copy;iTeach Soft Group 2021</a> <?=$logo['title_'.Yii::$app->language]?>.</p>
            <p><!-- START WWW.UZ TOP-RATING --><SCRIPT language="javascript" type="text/javascript">
                    top_js="1.0";top_r="id=45686&r="+escape(document.referrer)+"&pg="+escape(window.location.href);document.cookie="smart_top=1; path=/"; top_r+="&c="+(document.cookie?"Y":"N")
                    //-->
                </SCRIPT>
                <SCRIPT language="javascript1.1" type="text/javascript">
                    top_js="1.1";top_r+="&j="+(navigator.javaEnabled()?"Y":"N")
                    //-->
                </SCRIPT>
                <SCRIPT language="javascript1.2" type="text/javascript">
                    top_js="1.2";top_r+="&wh="+screen.width+'x'+screen.height+"&px="+
                        (((navigator.appName.substring(0,3)=="Mic"))?screen.colorDepth:screen.pixelDepth)
                    //-->
                </SCRIPT>
                <SCRIPT language="javascript1.3" type="text/javascript">
                    top_js="1.3";
                    //-->
                </SCRIPT>
                <SCRIPT language="JavaScript" type="text/javascript">
                    top_rat="&col=340F6E&t=ffffff&p=BD6F6F";top_r+="&js="+top_js+"";document.write('<a href="http://www.uz/ru/res/visitor/index?id=45686" target=_top><img src="http://cnt0.www.uz/counter/collect?'+top_r+top_rat+'" width=88 height=31 border=0 alt="Топ рейтинг www.uz"></a>')//-->
                </SCRIPT><NOSCRIPT><A href="http://www.uz/ru/res/visitor/index?id=45686" target=_top><IMG height=31 src="http://cnt0.www.uz/counter/collect?id=45686&pg=http%3A//uzinfocom.uz&&col=340F6E&amp;t=ffffff&amp;p=BD6F6F" width=88 border=0 alt="Топ рейтинг www.uz"></A></NOSCRIPT><!-- FINISH WWW.UZ TOP-RATING --></p>
        </div>
    </div>
</section>
