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

call_user_func(function() {
    error_reporting(-1);

    if ($_SERVER['SERVER_NAME'] === 'localhost') {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }

    session_save_path(realpath(__DIR__ . '/../cache/session/'));
    session_start();
});
