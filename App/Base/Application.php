<?php

namespace App\Base;

use App\Traits\Singleton;
use App\Services\Renderers\RendererInterface;
use Exception;
use ReflectionException;

/**
 * @property Request $request
 * @property Response $response
 * @property RendererInterface $renderer
 */
class Application
{
    use Singleton;

    protected ComponentsFactory $componentsFactory;
    protected array $config;
    protected $components;

    public function run(array $config): void
    {
        $this->componentsFactory = new ComponentsFactory();
        $this->config = $config;
        $controllerName = $this->request->getController() ?: $this->config['DEFAULT_CONTROLLER'];
        $params = $this->request->getAll();
        $actionName = $this->request->getAction();

        /**
         * Получаем имя класса контроллера с пространством имён
         * App\Controllers\UsersController\
         */
        $controllerClass = $this->config['CONTROLLER_NAMESPACE'] . ucfirst($controllerName) . "Controller";
        print_r($controllerClass);

        /**
         * Попытка вызвать у контроллера соответствующий метод
         */
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass($this->renderer);
            $controller->runAction($actionName, $params);
        } else {
            $this->response->redirect('notFound');
        }
    }


    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function __get($name)
    {
        /**
         * Если не найден компонент, проверяем есть ли он в конфиге, создаём его через фабрику и помещаем в $this->components
         */
        if (is_null($this->components) || empty($this->components[$name])) {
            if ($params = $this->config['COMPONENTS'][$name]) {
                $this->components[$name] = $this->componentsFactory->createComponent($name, $params);
            } else {
                throw new Exception("Не найдена конфигурация для компонента $name");
            }
        }

        return $this->components[$name];
    }
}
