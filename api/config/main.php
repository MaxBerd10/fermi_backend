<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'request' => [
            'baseUrl' => '',
            // Stateless token API — no cookies/session involved, so CSRF
            // (which protects cookie-authenticated form submits) does not apply.
            'enableCsrfValidation' => false,
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            'format' => \yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
            // Normalizes every response into {success,data,meta} / {success:false,error:{...}}.
            // Actions that already return an array with a 'success' key (see
            // api\controllers\BaseApiController::success()/fail()) pass through untouched.
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if (!is_array($response->data)) {
                    return;
                }
                if (array_key_exists('success', $response->data)) {
                    return;
                }
                if ($response->isSuccessful) {
                    $response->data = [
                        'success' => true,
                        'data' => $response->data,
                    ];
                } else {
                    $response->data = [
                        'success' => false,
                        'error' => [
                            'code' => $response->data['name'] ?? 'ERROR',
                            'message' => $response->data['message'] ?? 'An error occurred.',
                        ],
                    ];
                }
            },
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableSession' => false,
            'loginUrl' => null,
        ],
        'errorHandler' => [
            // No errorAction: response format is already JSON, so Yii's
            // ErrorHandler serializes exceptions/HttpException as JSON directly.
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
        'urlManager' => [
            'baseUrl' => '/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'POST v1/integrations/telegram/webhook' => 'integrations/telegram-webhook',
                'v1/auth/<action:[\w\-]+>' => 'auth/<action>',
                'v1/site/<action:[\w\-]+>' => 'site/<action>',

                'v1/menu' => 'menu/index',
                'v1/menu/<id:\d+>/breadcrumb' => 'menu/breadcrumb',

                'v1/home' => 'pages/home',
                'v1/settings' => 'lookup/settings',
                'v1/about/<slug>' => 'pages/about',
                'v1/pages/<slug>' => 'pages/page',
                'v1/faculty' => 'pages/faculty-index',
                'v1/faculty/<slug>' => 'pages/faculty-view',
                'v1/departments' => 'pages/departments-index',
                'v1/departments/<slug>' => 'pages/departments-view',
                'v1/leaders/<categorySlug>' => 'pages/leaders',
                'v1/documents/<slug>' => 'pages/documents',

                'v1/news' => 'news/index',
                'v1/news/category/<slug>' => 'news/category',
                'v1/news/<slug>' => 'news/view',

                'v1/gallery/full/<id:\d+>' => 'media/gallery-full',
                'v1/gallery' => 'media/gallery',
                'v1/video' => 'media/video',

                'v1/schedule' => 'pages/schedule',
                'v1/search' => 'pages/search',
                'v1/sitemap' => 'pages/sitemap',

                'v1/regions' => 'lookup/regions',
                'v1/districts' => 'lookup/districts',
                'v1/quarters' => 'lookup/quarters',
                'v1/connect-leaders' => 'lookup/connect-leaders',

                'v1/forms/<action:[\w\-]+>' => 'forms/<action>',

                // CORS preflight catch-all — must come before the verb-restricted
                // admin/* rules below, since those only match their own exact
                // HTTP method and would otherwise 404 an OPTIONS preflight.
                'OPTIONS v1/admin/<x:.*>' => 'admin-media/options',

                'GET v1/admin/media/list' => 'admin-media/list',
                'POST v1/admin/media/upload' => 'admin-media/upload',

                'GET v1/admin/menu-tree' => 'admin-menu/index',
                'POST v1/admin/menu-tree' => 'admin-menu/create',
                'PUT,PATCH v1/admin/menu-tree/<id:\d+>' => 'admin-menu/update',
                'DELETE v1/admin/menu-tree/<id:\d+>' => 'admin-menu/delete',
                'POST v1/admin/menu-tree/<id:\d+>/move' => 'admin-menu/move',

                'GET v1/admin/users' => 'admin-user/index',
                'POST v1/admin/users' => 'admin-user/create',
                'GET v1/admin/users/<id:\d+>' => 'admin-user/view',
                'PUT,PATCH v1/admin/users/<id:\d+>' => 'admin-user/update',
                'DELETE v1/admin/users/<id:\d+>' => 'admin-user/delete',

                'GET v1/admin/translations' => 'admin-translation/index',
                'POST v1/admin/translations' => 'admin-translation/create',
                'GET v1/admin/translations/<id:\d+>' => 'admin-translation/view',
                'PUT,PATCH v1/admin/translations/<id:\d+>' => 'admin-translation/update',
                'DELETE v1/admin/translations/<id:\d+>' => 'admin-translation/delete',

                'GET v1/admin/news' => 'admin-post/index',
                'POST v1/admin/news' => 'admin-post/create',
                'GET v1/admin/news/<id:\d+>' => 'admin-post/view',
                'PUT,PATCH v1/admin/news/<id:\d+>' => 'admin-post/update',
                'DELETE v1/admin/news/<id:\d+>' => 'admin-post/delete',

                'GET v1/admin/pages' => 'admin-page/index',
                'POST v1/admin/pages' => 'admin-page/create',
                'GET v1/admin/pages/<id:\d+>' => 'admin-page/view',
                'PUT,PATCH v1/admin/pages/<id:\d+>' => 'admin-page/update',
                'DELETE v1/admin/pages/<id:\d+>' => 'admin-page/delete',

                'GET v1/admin/postcategories' => 'admin-postcategory/index',
                'POST v1/admin/postcategories' => 'admin-postcategory/create',
                'GET v1/admin/postcategories/<id:\d+>' => 'admin-postcategory/view',
                'PUT,PATCH v1/admin/postcategories/<id:\d+>' => 'admin-postcategory/update',
                'DELETE v1/admin/postcategories/<id:\d+>' => 'admin-postcategory/delete',

                'GET v1/admin/faculty' => 'admin-faculty/index',
                'POST v1/admin/faculty' => 'admin-faculty/create',
                'GET v1/admin/faculty/<id:\d+>' => 'admin-faculty/view',
                'PUT,PATCH v1/admin/faculty/<id:\d+>' => 'admin-faculty/update',
                'DELETE v1/admin/faculty/<id:\d+>' => 'admin-faculty/delete',

                'GET v1/admin/departments' => 'admin-departments/index',
                'POST v1/admin/departments' => 'admin-departments/create',
                'GET v1/admin/departments/<id:\d+>' => 'admin-departments/view',
                'PUT,PATCH v1/admin/departments/<id:\d+>' => 'admin-departments/update',
                'DELETE v1/admin/departments/<id:\d+>' => 'admin-departments/delete',

                'GET v1/admin/leaders' => 'admin-leader/index',
                'POST v1/admin/leaders' => 'admin-leader/create',
                'GET v1/admin/leaders/<id:\d+>' => 'admin-leader/view',
                'PUT,PATCH v1/admin/leaders/<id:\d+>' => 'admin-leader/update',
                'DELETE v1/admin/leaders/<id:\d+>' => 'admin-leader/delete',

                'GET v1/admin/leadercategories' => 'admin-leadercategory/index',
                'POST v1/admin/leadercategories' => 'admin-leadercategory/create',
                'GET v1/admin/leadercategories/<id:\d+>' => 'admin-leadercategory/view',
                'PUT,PATCH v1/admin/leadercategories/<id:\d+>' => 'admin-leadercategory/update',
                'DELETE v1/admin/leadercategories/<id:\d+>' => 'admin-leadercategory/delete',

                'GET v1/admin/documents' => 'admin-documents/index',
                'POST v1/admin/documents' => 'admin-documents/create',
                'GET v1/admin/documents/<id:\d+>' => 'admin-documents/view',
                'PUT,PATCH v1/admin/documents/<id:\d+>' => 'admin-documents/update',
                'DELETE v1/admin/documents/<id:\d+>' => 'admin-documents/delete',

                'GET v1/admin/documents-items' => 'admin-documentsitem/index',
                'POST v1/admin/documents-items' => 'admin-documentsitem/create',
                'GET v1/admin/documents-items/<id:\d+>' => 'admin-documentsitem/view',
                'PUT,PATCH v1/admin/documents-items/<id:\d+>' => 'admin-documentsitem/update',
                'DELETE v1/admin/documents-items/<id:\d+>' => 'admin-documentsitem/delete',

                'GET v1/admin/gallery-images' => 'admin-img/index',
                'POST v1/admin/gallery-images' => 'admin-img/create',
                'GET v1/admin/gallery-images/<id:\d+>' => 'admin-img/view',
                'PUT,PATCH v1/admin/gallery-images/<id:\d+>' => 'admin-img/update',
                'DELETE v1/admin/gallery-images/<id:\d+>' => 'admin-img/delete',

                'GET v1/admin/videos' => 'admin-video/index',
                'POST v1/admin/videos' => 'admin-video/create',
                'GET v1/admin/videos/<id:\d+>' => 'admin-video/view',
                'PUT,PATCH v1/admin/videos/<id:\d+>' => 'admin-video/update',
                'DELETE v1/admin/videos/<id:\d+>' => 'admin-video/delete',

                'GET v1/admin/courses' => 'admin-course/index',
                'POST v1/admin/courses' => 'admin-course/create',
                'GET v1/admin/courses/<id:\d+>' => 'admin-course/view',
                'PUT,PATCH v1/admin/courses/<id:\d+>' => 'admin-course/update',
                'DELETE v1/admin/courses/<id:\d+>' => 'admin-course/delete',

                'GET v1/admin/schedules' => 'admin-schedule/index',
                'POST v1/admin/schedules' => 'admin-schedule/create',
                'GET v1/admin/schedules/<id:\d+>' => 'admin-schedule/view',
                'PUT,PATCH v1/admin/schedules/<id:\d+>' => 'admin-schedule/update',
                'DELETE v1/admin/schedules/<id:\d+>' => 'admin-schedule/delete',

                'GET v1/admin/corusel' => 'admin-corusel/index',
                'POST v1/admin/corusel' => 'admin-corusel/create',
                'GET v1/admin/corusel/<id:\d+>' => 'admin-corusel/view',
                'PUT,PATCH v1/admin/corusel/<id:\d+>' => 'admin-corusel/update',
                'DELETE v1/admin/corusel/<id:\d+>' => 'admin-corusel/delete',

                'GET v1/admin/counter' => 'admin-counter/index',
                'POST v1/admin/counter' => 'admin-counter/create',
                'GET v1/admin/counter/<id:\d+>' => 'admin-counter/view',
                'PUT,PATCH v1/admin/counter/<id:\d+>' => 'admin-counter/update',
                'DELETE v1/admin/counter/<id:\d+>' => 'admin-counter/delete',

                'GET v1/admin/setting' => 'admin-setting/index',
                'POST v1/admin/setting' => 'admin-setting/create',
                'GET v1/admin/setting/<id:\d+>' => 'admin-setting/view',
                'PUT,PATCH v1/admin/setting/<id:\d+>' => 'admin-setting/update',
                'DELETE v1/admin/setting/<id:\d+>' => 'admin-setting/delete',

                'GET v1/admin/logo' => 'admin-logo/index',
                'POST v1/admin/logo' => 'admin-logo/create',
                'GET v1/admin/logo/<id:\d+>' => 'admin-logo/view',
                'PUT,PATCH v1/admin/logo/<id:\d+>' => 'admin-logo/update',
                'DELETE v1/admin/logo/<id:\d+>' => 'admin-logo/delete',

                'GET v1/admin/networks' => 'admin-network/index',
                'POST v1/admin/networks' => 'admin-network/create',
                'GET v1/admin/networks/<id:\d+>' => 'admin-network/view',
                'PUT,PATCH v1/admin/networks/<id:\d+>' => 'admin-network/update',
                'DELETE v1/admin/networks/<id:\d+>' => 'admin-network/delete',

                'GET v1/admin/useful-sites' => 'admin-useful-sites/index',
                'POST v1/admin/useful-sites' => 'admin-useful-sites/create',
                'GET v1/admin/useful-sites/<id:\d+>' => 'admin-useful-sites/view',
                'PUT,PATCH v1/admin/useful-sites/<id:\d+>' => 'admin-useful-sites/update',
                'DELETE v1/admin/useful-sites/<id:\d+>' => 'admin-useful-sites/delete',

                'GET v1/admin/about' => 'admin-about/index',
                'POST v1/admin/about' => 'admin-about/create',
                'GET v1/admin/about/<id:\d+>' => 'admin-about/view',
                'PUT,PATCH v1/admin/about/<id:\d+>' => 'admin-about/update',
                'DELETE v1/admin/about/<id:\d+>' => 'admin-about/delete',

                'GET v1/admin/contacts' => 'admin-contact/index',
                'POST v1/admin/contacts' => 'admin-contact/create',
                'GET v1/admin/contacts/<id:\d+>' => 'admin-contact/view',
                'PUT,PATCH v1/admin/contacts/<id:\d+>' => 'admin-contact/update',
                'DELETE v1/admin/contacts/<id:\d+>' => 'admin-contact/delete',

                'GET v1/admin/acceptances' => 'admin-acceptance/index',
                'POST v1/admin/acceptances' => 'admin-acceptance/create',
                'GET v1/admin/acceptances/<id:\d+>' => 'admin-acceptance/view',
                'PUT,PATCH v1/admin/acceptances/<id:\d+>' => 'admin-acceptance/update',
                'DELETE v1/admin/acceptances/<id:\d+>' => 'admin-acceptance/delete',

                'GET v1/admin/virtual-submissions' => 'admin-virtual/index',
                'POST v1/admin/virtual-submissions' => 'admin-virtual/create',
                'GET v1/admin/virtual-submissions/<id:\d+>' => 'admin-virtual/view',
                'PUT,PATCH v1/admin/virtual-submissions/<id:\d+>' => 'admin-virtual/update',
                'DELETE v1/admin/virtual-submissions/<id:\d+>' => 'admin-virtual/delete',

                'GET v1/admin/connect-leaders' => 'admin-connect-leader/index',
                'POST v1/admin/connect-leaders' => 'admin-connect-leader/create',
                'GET v1/admin/connect-leaders/<id:\d+>' => 'admin-connect-leader/view',
                'PUT,PATCH v1/admin/connect-leaders/<id:\d+>' => 'admin-connect-leader/update',
                'DELETE v1/admin/connect-leaders/<id:\d+>' => 'admin-connect-leader/delete',
            ],
        ],
    ],
    'params' => $params,
];
