<?php

namespace App\Controllers;

use App\Models\AbstractModel;
use App\Models\Record;
use App\Services\Renderers\RendererInterface;
use ReflectionException;

abstract class AbstractController
{
    protected const DEFAULT_ACTION = 'index';
    protected const NOT_FOUND_PAGE_NAME = '404';
    protected string $action;
    protected RendererInterface $renderer;
    protected array $attendant;
    protected array $totalDutiesArrey;
    protected int $totalDuties;
    protected int $totalMissedDuties;
    protected int $totalDoneDuties;
    protected bool $requireAuth = true;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
        app()->session->remove('errors');
        $isAuthorized = app()->auth->isAuthorized();

        if ($this->requireAuth && $isAuthorized) {
            return;
        }

        if ($this->requireAuth) {
            header('Location: /auth');
        }

        if ($isAuthorized) {
            header('Location: /');
        }
    }

    /**
     * @throws \ReflectionException
     */
    public function runAction(?string $action = null, ?array $params = [], ?int $modelId = 0): void
    {
        $this->action = $action ?: ($modelId != 0 ? 'show' : self::DEFAULT_ACTION);

//      Добавляет префикс 'action' к названию для поиска метода ///actionAll
        $method = "action" . ucfirst($this->action);

        if (method_exists($this, $method)) {
            $this->bindParams($params, $method, $modelId);
            $this->attendant = (new Record())->getRecordsWithUsers(date('Y-m-d'), date('Y-m-d'))[0]; 
            $this->totalDutiesArrey = (new Record())->getByRange(date('Y-m') . '-01', date('Y-m') . '-' . date('d') - 1, 'date');
            $this->totalDuties = count($this->totalDutiesArrey);
            $this->totalDoneDuties = array_sum(array_column($this->totalDutiesArrey, 'status'));
            $this->totalMissedDuties = $this->totalDuties - $this->totalDoneDuties;
            $this->$method(...$params);
        } else {
            echo $this->renderer->render(self::NOT_FOUND_PAGE_NAME);
        }
    }

    /** РЕНДЕРИТ шаблон
     * @param string $template
     * @param array $params
     * @return string
     */
    protected function render(string $template, array $params = []): string
    {
        return $this->renderer->render($template, $params);
    }

    /**
     * @throws ReflectionException
     */
    private function bindParams(?array &$data, ?string $method, ?int $modelId): void
    {
        $params = [];

        $reflection = new \ReflectionClass($this);
        $reflectionParameters = $reflection->getMethod($method)?->getParameters();

        if (!$reflectionParameters || !count($reflectionParameters)) {
            $data = $params;
            return;
        }

        foreach ($reflectionParameters as $parameter) {
            $typeName = $parameter->getType()?->getName() ?? '';
            
            if ($typeName === 'array') {
                $params[$parameter->getName()] = $data;
                continue;
            }

            if (!class_exists($typeName)) {
                continue;
            }

            $class = new $typeName();

            if (!$class instanceof AbstractModel || (!$data || !array_key_exists('id', $data)) && is_null($modelId)) {
                $params[$parameter->getName()] = $class;
                continue;
            }

            $params[$parameter->getName()] = $class->find($modelId ?: $data['id']);
        }
        
        $data = $params;
    }
}
