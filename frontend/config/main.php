<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language'=>'uz',
    'homeUrl'=>['site/index'],
    'controllerNamespace' => 'frontend\controllers',
    'modules'=>[
        
        // 'debug' => [
        //     'class' => 'yii\debug\Module',
        //     'allowedIPs' => ['*'], // faqat testda!
        // ],
        'pdfjs' => [
                'class' => '\yii2assets\pdfjs\Module',
        ],

        'comment' => [
            'class' => 'yii2mod\comments\Module',
            'controllerMap' => [
                'default' => [
                    'class' => 'yii2mod\comments\controllers\DefaultController',
                    'on beforeCreate' => function ($event) {
                        $event->getCommentModel();
                        // your custom code
                    },
                    'on afterCreate' => function ($event) {
                        $event->getCommentModel();
                        // your custom code
                    },
                    'on beforeDelete' => function ($event) {
                        $event->getCommentModel();
                        // your custom code
                    },
                    'on afterDelete' => function ($event) {
                        $event->getCommentModel();
                        // your custom code
                    },
                ]
            ]
        ]
    ],
    'components' => [
        'i18n' => [
            'translations' => [
                'yii2mod.comments' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/comments/messages',
                ],
                'app' => [
                    'class' => 'yii\i18n\DbMessageSource',
                ],
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js' => [
                        'js/jquery-3.3.1.min.js',
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null,
                    'css' => [
                        'css/bootstrap.css',
                        //'css/bootstrap.min.css',
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                    ]
                ]
            ],
        ],

        'request' => [
            'baseUrl' => '/',
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'baseUrl' => '/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'uz/'=>'site/index/',
                '/ru'=>'site/index',
                '/en'=>'site/index',
               // 'news'=>'site/news',
                'galereya'=>'site/gallery',
                'video'=>'site/video',
                'about/<id>'=>'site/about',
                'full-gallery/<id>'=>'site/full-gallery',
                'fuu-news/<id>'=>'site/news-detail',
                'contact-form'=>'site/contact-form',
                'sports/<id>'=>'site/sports',
                'detail/<id>'=>'site/detail',
                'sitemap'=>'site/sitemap',
                'documents/<menu_id>/<id>'=>'site/documents',
                'blog/<menu_id>/<id>'=>'site/page',
                'leader/<menu_id>/<id>'=>'site/rahbariyat',
                'faculty/<menu_id>/<id>'=>'site/fakultet',
                'departments/<menu_id>/<id>'=>'site/kafedra',
                'virtual-reception/<menu_id>'=>'site/virtual-reception',
                'news/<menu_id>/<id>'=>'site/news',
                'events/<id>'=>'site/events'
            ],
        ],

    ],
    'as beforeRequest'=>
        [
            'class'=>'frontend\components\TilAl'
        ],
    'params' => $params,
];