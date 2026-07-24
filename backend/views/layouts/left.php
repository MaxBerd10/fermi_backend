<aside class="main-sidebar">
    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?=Yii::$app->user->identity->username?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="# method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => "Menyular",
                        'icon' => 'fas fa-database',
                        'url' => '#',
                        'items' => [
                            ['label' => "Menyular", 'icon' => 'fas fa-database', 'url' => ['/menumanager'],],
                        ],
                    ],
                    [
                        'label' => "Ma'lumot",
                        'icon' => 'fas fa-database',
                        'url' => '#',
                        'items' => [
                            ['label' => "Ma'lumot", 'icon' => 'fas fa-database', 'url' => ['/page'],],
                            ['label' => "Ma'lumot qo'shish", 'icon' => 'fas fa-database', 'url' => ['/page/create'],],
                        ],
                    ],
                    [
                        'label' => "Yangiliklar",
                        'icon' => 'far fa-newspaper',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Yangilik turi', 'icon' => 'far fa-newspaper', 'url' => ['/postcategory'],],
                            ['label' => "Yangiliklar", 'icon' => 'far fa-newspaper', 'url' => ['/post'],],
                        ],
                    ],
                    [
                        'label' => 'Kafedralar',
                        'icon' => 'fas fa-user',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Kafedralar', 'icon' => 'fas fa-user', 'url' => ['/departments'],],
                            ['label' => "Kafedralar qo'shish", 'icon' => 'fas fa-user', 'url' => ['/departments/create'],],
                        ],
                    ],
                    [
                        'label' => 'Rasmlar',
                        'icon' => 'fas fa-image',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Rasmlar', 'icon' => 'fas fa-user', 'url' => ['/img'],],
                        ],
                    ],
                    [
                        'label' => 'Fakultetlar',
                        'icon' => 'fas fa-user',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Fakultetlar', 'icon' => 'fas fa-user', 'url' => ['/faculty'],],
                            ['label' => "Fakultetlar qo'shish", 'icon' => 'fas fa-user', 'url' => ['/faculty/create'],],
                        ],
                    ],
                    [
                        'label' => "Me'yoriy xujjatlar",
                        'icon' => 'fas fa-user',
                        'url' => '#',
                        'items' => [
                            ['label' => "Me'yoriy xujjatlar turi", 'icon' => 'fas fa-user', 'url' => ['/documents'],],
                            ['label' => "Me'yoriy xujjatlar", 'icon' => 'fas fa-user', 'url' => ['/documents-item'],],
                        ],
                    ],
                    [
                        'label' => 'Rahbariyat',
                        'icon' => 'fas fa-user',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Rahbariyat turi', 'icon' => 'fas fa-user', 'url' => ['/leadercategory'],],
                            ['label' => "Rahbariyat", 'icon' => 'fas fa-user', 'url' => ['/leader'],],
                        ],
                    ],
                    [
                        'label' => 'Logo',
                        'icon' => 'fas fa-user',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Logo', 'icon' => 'fas fa-user', 'url' => ['/logo'],],
                            ['label' => 'Logo create', 'icon' => 'fas fa-user', 'url' => ['/logo/create'],],
                        ],
                    ],
                    [
                        'label' => 'Ijtimoiy tarmoqlar',
                        'icon' => 'far fa-share-alt',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Ijtimoiy tarmoqlar', 'icon' => 'far fa-share-alt', 'url' => ['/network'],],
                        ],
                    ],
                    [
                        'label' => 'Setting',
                        'icon' => 'fas fa-cogs',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Setting', 'icon' => 'fas fa-cogs', 'url' => ['/setting'],],
                            ['label' => 'Setting create', 'icon' => 'fas fa-cogs', 'url' => ['/setting/create'],],
                        ],
                    ],
                    [
                        'label' => 'Corusel',
                        'icon' => 'fas fa-image',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Corusel', 'icon' => 'book', 'url' => ['/corusel'],],
                            ['label' => 'Corusel create', 'icon' => 'book', 'url' => ['/corusel/create'],],
                        ],
                    ],
                    [
                        'label' => 'Video',
                        'icon' => 'fas fa-video',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Video', 'icon' => 'fas fa-video', 'url' => ['/video'],],
                            ['label' => 'Video create', 'icon' => 'fas fa-video', 'url' => ['/video/create'],],
                        ],
                    ],  [
                        'label' => 'Foydali saytlar',
                        'icon' => 'fas fa-address-book',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Foydali saytlar', 'icon' => 'book', 'url' => ['/useful-sites'],],
                            ['label' => "Foydali saytlar qo'shish", 'icon' => 'book', 'url' => ['/useful-sites/create'],],
                        ],
                    ],
                    [
                        'label' => 'Static raqamlar',
                        'icon' => 'fas fa-address-book',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Static raqamlar', 'icon' => 'book', 'url' => ['/counter'],],
                        ],
                    ],
                    [
                        'label' => 'Biz haqimizda',
                        'icon' => 'fas fa-address-book',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Biz haqimizda', 'icon' => 'book', 'url' => ['/about'],],
                        ],
                    ],
                    [
                        'label' => 'Dars jadval',
                        'icon' => 'fas fa-address-book',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Kurslar', 'icon' => 'book', 'url' => ['/course'],],
                            ['label' => 'dars jadvali', 'icon' => 'book', 'url' => ['/schedule'],],
                        ],
                    ],
                    [
                        'label' => 'Contact',
                        'icon' => 'fas fa-address-book',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Contact', 'icon' => 'book', 'url' => ['/acceptance'],],
                            ['label' => 'connect-leader', 'icon' => 'book', 'url' => ['/connect-leader'],],

                        ],
                    ],

                ],
            ]
        ) ?>

    </section>

</aside>
