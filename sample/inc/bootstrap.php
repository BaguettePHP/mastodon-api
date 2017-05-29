<?php

/**
 * Template for all contents
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/variables.php';
require_once __DIR__ . '/app.php';

const SERVICE_NAME = 'PhpMastodonSDK SampleApp';

call_user_func(function() {
    error_reporting(-1);

    if (!is_production()) {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }

    $dotenv = new Dotenv\Dotenv(dirname(__DIR__));
    $dotenv->load();
    $dotenv->required('MY_PHP_ENV');
    $dotenv->required('SERVICE_BASE_URL');

    session_save_path(realpath(__DIR__ . '/../cache/session/'));
    session_start();

    app\gc_session();
});
