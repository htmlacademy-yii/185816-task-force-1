<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['gii'],
    'language' => 'ru-RU',
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['192.168.10.10', '::1', '192.168.10.*', '192.168.10.10']
        ],
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['192.168.10.10', '::1', '192.168.10.*', '192.168.10.10']
        ],
        'api' => [
            'class' => 'frontend\modules\api\Module',
        ],
    ],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'authClientCollection' => [
            'class' => yii\authclient\Collection::class,
            'clients' => [
                'vkontakte' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => '7515660',
                    'clientSecret' => 'bMEQFPcHlgweqppYYSLJ',
                ],
            ],
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'cookieValidationKey' => 'asdasdas',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => \common\models\User::class,
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
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/index',
                'tasks' => 'tasks/index',
                'tasks/<id:\d+>' => 'tasks/view',
                'task/cancel/<id:\d+>' => 'task/cancel',
                'task/work/<id:\d+>/<executor:\d+>' => 'task/work',
                'task/refuse/<id:\d+>' => 'task/refuse',
                'task/complete/<id:\d+>' => 'task/complete',
                'users' => 'users/index',
                'users/<id:\d+>' => 'users/view',
                'users/sort/<sort:>' => 'users/sort',
                'response/new/<task_id:\d+>' => 'response/new',
                'response/cancel/<id:\d+>' => 'response/cancel',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/messages'
                ],
                'api/messages/task/<id:\d+>' => 'api/messages/task',
                'event/disable/<id:\d+>' => 'event/disable'
            ],
        ],
    ],
    'params' => $params,
];
