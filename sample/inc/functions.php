<?php

/**
 * Helper functions for SampleApp
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */

use Monolog\Logger;
use Monolog\Handler\ChromePHPHandler;
use Monolog\Handler\NoopHandler;
use Monolog\Handler\StreamHandler;
use Teto\Routing\Router;

/**
 * @param  string $input
 * @return string
 */
function h($input)
{
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

/**
 * @param string $tpl_name
 * @param array $data
 * @return string
 */
function view($tpl_name, array $data = [])
{
    $main_tpl = __DIR__ . "/../view/{$tpl_name}.tpl.php";
    if (!file_exists($main_tpl)) {
        throw new \RuntimeException("Template file not exists: {$tpl_name}");
    }

    ob_start();
    $var = new variables($data);
    include __DIR__ . '/../view/body.tpl.php';

    return ob_get_clean();
}

/**
 * @param  Router $router
 * @return Router
 */
function router(Router $router = null)
{
    /** @var Router $cache */
    static $cache;

    if ($router !== null) {
        $cache = $router;
    }

    return $cache;
}

/**
 * @param  array $input
 * @return void
 */
function set_flash(array $input)
{
    $has_flash = !isset($_SESSION['_flash']) || !is_array($_SESSION['_flash']);
    $flash = $has_flash ? $_SESSION['_flash'] : [];

    foreach ($input as $key => $item) {
        $flash[$key] = filter_var($item, FILTER_DEFAULT);
    }

    $_SESSION['_flash'] = $flash;
}

/**
 * @param array  $flash
 * @return array
 */
function last_flash(array $flash = null)
{
    /** @var array $last_flash */
    static $last_flash = [];

    if ($flash !== null) {
        $last_flash = $flash;
    }

    return $last_flash;
}

/**
 * @return \Monolog\Logger
 */
function app_log()
{
    /** @var \Monolog\Logger */
    static $logger;

    if ($logger === null) {
        $path = implode(DIRECTORY_SEPARATOR, [__DIR__, getenv('MY_PHP_ENV') . '.php']);
        $fp = fopen($path, 'wb+');
        $logger = new \Monolog\Logger('');
        $logger->pushHandler(new StreamHandler($fp, Logger::INFO, true, null, true));
    }

    return $logger;
}

/**
 * @return \Monolog\Logger
 */
function chrome_log()
{
    /** @var \Monolog\Logger */
    static $logger;

    if ($logger === null) {
        $logger  = new \Monolog\Logger('');
        $handler = is_production() ? new NoopHandler : new ChromePHPHandler(Logger::INFO);
        $logger->pushHandler($handler);
    }

    return $logger;
}

/**
 * @return bool
 */
function is_production()
{
     return getenv('MY_PHP_ENV') === 'production';
}
