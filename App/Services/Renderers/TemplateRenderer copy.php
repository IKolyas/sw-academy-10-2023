<?php

namespace App\Services\Renderers;

class TemplateRenderer implements RendererInterface
{

    public function render(string $template, array $params = []): string
    {
//      TODO: вынести директорию представления в конфиг. Получать из конфига
        ob_start(); // Включение буферизации вывода
        $templatePath = $_SERVER['DOCUMENT_ROOT'] . '/../views/' . $template . ".php";
        // $templatePath = $_SERVER['DOCUMENT_ROOT'] . '/../views/layouts/calendar.html';
        // /var/www/html/public/../views/layouts/main.php
        // /var/www/html/public/../views/layouts/calendar.html

        extract($params);  //Подготавливает переменные для использования в шаблоне
        // print_r($templatePath);
        include $templatePath;

        return ob_get_clean(); //Получает текущее содержимое буфера и удаляет текущий выходной буфер.
    }
}
