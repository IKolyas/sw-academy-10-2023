<?php

namespace App\Services\Renderers;

class TemplateRenderer implements RendererInterface
{

    public function render(string $template, array $params = []): string
    {
//      TODO: вынести директорию представления в конфиг. Получать из конфига
        ob_start();
        $templatePath = $_SERVER['DOCUMENT_ROOT'] . '/../views/' . $template . ".php";
        extract($params);
        include $templatePath;

        return ob_get_clean();
    }
}
