<?php

/**
 * Mastodon SampleApp routes config
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */

use Teto\Routing\Action;
use Baguette\Mastodon as m;

$routes = [];
$routes['index'] = ['GET', '/', function (Action $action) {
    return [200, [], view('index')];
}];

$routes['license'] = ['GET', '/license', function (Action $action) {
    $path = __DIR__ . '/../../LICENSE';
    return [200, ['Content-Type' => 'text/plain;charset=UTF-8'], file_get_contents($path)];
}];

$routes['post_login'] = ['POST', '/login', function (Action $action) {
    $acct_input = filter_input(INPUT_POST, 'acct', FILTER_DEFAULT);
    $acct = ltrim($acct_input, '@');

    if (strpos($acct, '@') === false) {
        set_flash(['error' => "Invalid Mastodon account: {$acct_input}"]);
        return [302, ['Location' => '/'], null];
    }

    list($user, $instance) = explode('@', $acct, 2);

    $client = new m\Client($instance, ['name' => SERVICE_NAME]);
    $scope = m\scope('read write follow');
    $callback_url = app\get_service_base_url() . router()->makePath('auth_callback');

    try {
        $app = app\get_client_app($client, $scope, [$callback_url]);
    } catch (\Exception $e) {
        set_flash(['error' => $e->getMessage()]);
        return [302, ['Location' => '/'], null];
    }

    $_SESSION['mastodons'] = isset($_SESSION['mastodons']) ? $_SESSION['mastodons'] : [];

    if (isset($_SESSION['mastodons'][$instance])) {
        set_flash(['error' => "already linked to {$instance}"]);
        return [302, ['Location' => '/'], null];
    }

    //$_SESSION['mastodons'][$instance] = [];
    $auth = new m\Service\AuthFactory($client, $app['client_id'], $app['client_secret']);

    $redirect_url = m\Grant\CodeGrant::getRedirectUrl($client, $auth, $scope, $callback_url);
    return [302, ['Location' => $redirect_url], null];
}];

$routes['auth_callback'] = ['GET', '/auth/callback', function (Action $action) {
    var_dump($action);
    //$
    exit;

    return [302, ['Location' => '/'], null];
}];

$routes['#404'] = function (Action $action) {
    return [404, [], view('404')];
};

return $routes;
