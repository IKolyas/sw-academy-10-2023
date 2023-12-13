<?php

/**
 * DEFAULT_CONTROLLER: контроллер по умолчанию (url("/"))
 * CONTROLLER_NAMESPACE: пространство имен контроллеров
 * COOKIE_TIME: время хранения куки зарегистрированного пользователя
 * COMPONENTS: Массив для регистрации компонентов в экземпляре приложения.
 * Массив можно расширить добавляя необходимые компоненты для дальнейшего их использования.
 */

use App\Base\Cookie;
use App\Base\Request;
use App\Base\Response;
use App\Services\DataBase;
use App\Services\Renderers\TemplateRenderer;

return [
    'DEFAULT_CONTROLLER' => env('DEFAULT_CONTROLLER', '/'),
    'CONTROLLER_NAMESPACE' => 'App\Controllers\\',
    'COOKIE_TIME' => env('COOKIE_TIME', 3600),
    'COMPONENTS' => [
        'request' => [
            'class' => Request::class,
        ],
        'response' => [
            'class' => Response::class,
        ],
        'renderer' => [
            'class' => TemplateRenderer::class,
        ],
        'cookie' => [
            'class' => Cookie::class,
        ],
        'db' => [
            'class' => DataBase::class,
        ]
    ]
];