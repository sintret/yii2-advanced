<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'sintret-backend',
    'name' => 'advanced',
    'layout' => 'adminlte',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'dynagrid' => [
            'class' => '\kartik\dynagrid\Module',
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            'downloadAction' => 'gridview/export/download',
            'i18n' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@kvdynagrid/messages',
                'forceTranslation' => true
            ]
        ]
    ],
    'components' => [
        'urlManager' => [
            'class' => 'common\components\SintretUrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'logout' => 'site/logout',
                'login' => 'site/login',
                'index' => 'site/index',
            //'debug/<controller>/<action>' => 'debug/<controller>/<action>',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'util' => [
            'class' => 'common\components\Util',
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
    ],
    'params' => $params,
];
