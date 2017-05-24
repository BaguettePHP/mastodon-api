<?php

/**
 * Mastodon SampleApp core application file
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */

require __DIR__ . '/../inc/bootstrap.php';

if (php_sapi_name() === 'cli-server') {
    if (strpos($_SERVER['REQUEST_URI'], '..') !== false) {
        http_response_code(404);
        return true;
    }
    $path = __DIR__ . implode(DIRECTORY_SEPARATOR, explode('/', $_SERVER['REQUEST_URI']));
    if (is_file($path)) {
        return false;
    }
}

$routes = require(__DIR__ . '/../inc/routes.php');

router($router = new \Teto\Routing\Router($routes));

$action = $router->match($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

/**
 * @var int   $status
 * @var array $headers
 * @var string|false $content
 */
list($status, $headers, $content) = call_user_func($action->value, $action);

http_response_code($status);
foreach ($headers as $name => $header) {
    header("{$name}:{$header}");
}

if ($content !== null) {
    echo (string)$content;
}
