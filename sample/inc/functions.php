<?php

/**
 * Helper functions for SampleApp
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */

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
