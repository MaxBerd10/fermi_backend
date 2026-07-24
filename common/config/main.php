<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'treemanager' =>  [
            'class' => '\kartik\tree\Module',
            // other module settings, refer detailed documentation
        ],
        'menumanager' => [
            'class' => 'backend\modules\menumanager\Module'
        ],
        // 'debug' => [
        //   'class' => 'yii\debug\Module',
        //     'allowedIPs' => ['*'], // faqat testda!
        // ],

    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
