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
use App\Base\Session;
use App\Services\Auth;
use App\Services\DataBase;
use App\Services\Renderers\TwigRenderer;

return [
    'DEFAULT_CONTROLLER' => env('DEFAULT_CONTROLLER', '/'),
    'CONTROLLER_NAMESPACE' => 'App\Controllers\\',
    'COOKIE_TIME' => env('COOKIE_TIME', 3600),
    'VIEWS_DIR' => __DIR__ . '/../views/',
    'UPLOADS_DIR' => __DIR__ . '/../public/uploads/',
    'COMPONENTS' => [
        'request' => [
            'class' => Request::class,
        ],
        'response' => [
            'class' => Response::class,
        ],
        'renderer' => [
            'class' => TwigRenderer::class,
        ],
        'cookie' => [
            'class' => Cookie::class,
        ],
        'db' => [
            'class' => DataBase::class,
        ],
        'session' => [
            'class' => Session::class,
        ],
        'auth' => [
            'class' => Auth::class,
        ]
    ]
];
