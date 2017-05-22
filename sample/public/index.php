<?php

/**
 * Mastodon SampleApp router and core application file
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */

use Teto\Routing\Action;

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

$routes = [];
$routes['index'] = ['GET', '/', function (Action $action) {
    return [200, [], view('index')];
}];

router($router = new \Teto\Routing\Router($routes));
$action = $router->match($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
list($status, $headers, $content) = call_user_func($action->value, $action);

http_response_code($status);
foreach ($headers as $name => $header) {
    header("{$name}:{$header}");
}

if ($content !== null) {
    echo (string)$content;
}
