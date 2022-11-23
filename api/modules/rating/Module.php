<?php

namespace api\modules\rating;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\web\UrlRule;

/**
 * v1 module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'api\modules\rating\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => CompositeAuth::class,
            'except' => [
                '*/options',
                'user/login',
                '*/*'
            ],
            'optional' => [
            ],
            'authMethods' => [
                HttpBearerAuth::class,
            ],
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => static::allowedDomains(),
                'Access-Control-Request-Method' => ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'OPTIONS', 'DELETE'],
                'Access-Control-Max-Age' => 3600,
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Expose-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Allow-Methods' => ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'OPTIONS', 'DELETE'],
                'Access-Control-Allow-Headers' => ['Authorization', 'X-Requested-With', 'content-type'],
            ],
        ];
        return $behaviors;
    }

    /**
     * @var array
     */
    public static $urlRules = [
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'rating/user',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS login' => 'options',
                'POST login' => 'login',

                'GET get-me' => 'get-me',

                'POST ' => 'create',


            ]
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'rating/university',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS ' => 'options',

                'OPTIONS <year:\d+>' => 'options',
                'GET <year:\d+>' => 'index',

                'OPTIONS <id:\d+>/view' => 'options',
                'GET <id:\d+>/view' => 'view',

                'POST' => 'create',
                'PUT <id:\d+>' => 'update',
                'DELETE <id:\d+>' => 'delete',
            ]
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'rating/school',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS ' => 'options',

                'OPTIONS <year:\d+>' => 'options',
                    'GET <year:\d+>' => 'index',

                'POST' => 'create',
                'PUT <id:\d+>' => 'update',
                'DELETE <id:\d+>' => 'delete',
            ]
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'rating/liceum',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS ' => 'options',

                'GET' => 'index',
                'POST' => 'create',
                'PUT <id:\d+>' => 'update',
                'DELETE <id:\d+>' => 'delete',
            ]
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'rating/region',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS ' => 'options',

                'OPTIONS <id:\d+>/district' => 'options',
                'GET <id:\d+>/district' => 'district',

                'OPTIONS district' => 'options',
                'GET district' => 'district-list',

                'POST' => 'create',
                'PUT <id:\d+>' => 'update',
                'DELETE <id:\d+>' => 'delete',
            ]
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'rating/employee',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS ' => 'options',

                'GET' => 'index',
                'POST' => 'create',
                'PUT <id:\d+>' => 'update',
                'DELETE <id:\d+>' => 'delete',
            ]
        ],
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'rating/company',
            'pluralize' => false,
            'patterns' => [
                'OPTIONS <action>' => 'options',
                'OPTIONS ' => 'options',

                'GET' => 'index',
                'POST' => 'create',
                'PUT <id:\d+>' => 'update',
                'DELETE <id:\d+>' => 'delete',
            ]
        ],
    ];

    /**
     * @return array
     */
    public static function allowedDomains()
    {
        return [
            '*',
        ];
    }
}
