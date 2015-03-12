<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'name' => 'advanced',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'urlManager' => [
            'class' => 'common\components\SintretUrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'logout' => 'site/logout',
                'login' => 'site/login',
                '' => 'site/index',
                'blog' => 'site/blog',
                'portfolio' => 'site/portfolio',
                'contact' => 'site/contact',
                'blog_detail/<id:\d+>/<title:[\w.]+>' => 'site/blog_detail',
                'portfolio_detail/<id:\d+>/<title:[\w.]+>' => 'site/portfolio_detail',
            //'debug/<controller>/<action>' => 'debug/<controller>/<action>',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\Member',
            'enableAutoLogin' => true,
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
