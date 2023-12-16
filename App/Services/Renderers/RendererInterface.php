<?php

namespace App\Services\Renderers;

interface RendererInterface
{
    public function render(string $template, array $params = []);
}