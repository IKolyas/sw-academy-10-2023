<?php

namespace App\Services\Renderers;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class TwigRenderer implements RendererInterface
{
    protected Environment $renderer;

    public function __construct()
    {
        $viewsDir = app()->getConfig('VIEWS_DIR');
        $loader = new FilesystemLoader($viewsDir);
        $this->renderer = new Environment($loader);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function render(string $template, array $params = []): string
    {
        $template = str_replace('.', '/', $template) . ".twig";
        return $this->renderer->render($template, $params);
    }
}
