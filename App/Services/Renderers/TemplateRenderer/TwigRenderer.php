<?php

namespace App\Services\Renderers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TemplateCalendar implements RendererInterface

{
  /**
   * The Twig\Environment singleton.
   * 
   * @var Environment
   */
  public static $instance;

  private function __construct()
  {
    $viewDir = app()->config->get('view\\\');
  }
  final public function __clone()
  {
  }
  final public function __wakeup()
  {
  }

  public static function twigEnvironment()
  {
    if (is_null(static::$instance)) {
      static::$instance = static::buildTwigEnvironment();
    }

    return static::$instance;
  }

  public static function buildTwigEnvironment()
  {
    $loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '../templates');

    return new Environment($loader, [
      // 'debug' => (bool) config()->get('app.debug'),
      // 'debug' => true,
      // 'auto_reload' => true,
      // 'cache' => $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '../Cache', // кэширование
    ]);

    // удалить:
    // $this->loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '../templates'); // настройки Twig
    // $this->twig = new Environment($this->loader, [ // настройки Twig
    // 'debug' => true, // отладка
    // 'auto_reload' => true,
    // 'cache' => $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '../Cache', // кэширование
    // ]);
    // $template = $twig->load('index.html'); Загрузка темплейта
    // echo $template->render(['the' => 'variables', 'go' => 'here']); Вывод темплейта
  }

  public function render(string $template, array $params = [])
  {
    return 'ghfjhgdhgkddfgdf';
    // echo static::twigEnvironment()->render($template, $params);
    // ob_start(); // Включение буферизации вывода
    // $templatePath = $_SERVER['DOCUMENT_ROOT'] . '/../views/' . $template . ".php";
    // // $templatePath = $_SERVER['DOCUMENT_ROOT'] . '/../views/layouts/calendar.html';

    // extract($params);  //Подготавливает переменные для использования в шаблоне
    // // print_r($templatePath);
    // include $templatePath;

    // return ob_get_clean(); //Получает те
  }
}

