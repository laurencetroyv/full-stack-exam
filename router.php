<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = [];

function abort(int $code = 404): void
{
    http_response_code($code);

    require __DIR__ . '/views/error.php';

    die();
}

function navigateTo($uri, $routes): void
{
    if (!array_key_exists($uri, $routes)) {
        abort(404);
    }

    require $routes[$uri];
}

navigateTo($uri, $routes);