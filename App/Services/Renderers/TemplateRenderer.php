<?php

namespace App\Services\Renderers;
// header('Content-Type: application/json');


class TemplateRenderer implements RendererInterface
{

    public function render(string $template, array $params = []): string
    {
//      TODO: вынести директорию представления в конфиг. Получать из конфига
        ob_start(); // Включение буферизации вывода
        $templatePath = $_SERVER['DOCUMENT_ROOT'] . '/../views/' . $template . ".php";
        // $templatePath = $_SERVER['DOCUMENT_ROOT'] . '/../views/layouts/calendar.html';

        extract($params);  //Подготавливает переменные для использования в шаблоне
        // foreach ($params as $key => $value) {
            // $key = $value;
            // print_r($key);
        // }
        // echo "<br>";
        // print_r($users[0]->first_name);
        // print_r($users[0]);

        // exit();

        include $templatePath;

        return ob_get_clean(); //Получает текущее содержимое буфера и удаляет текущий выходной буфер.
    }
}
