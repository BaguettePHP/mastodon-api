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
use Baguette\Mastodon\Service\AuthFactory;
use Baguette\Mastodon\Grant\CodeGrant;

const RE_ACCT = '/\A[_a-z0-9]+@[-:.a-z0-9]+\z/';

$routes = [];
$routes['index'] = ['GET', '/', function (Action $action) {
    chrome_log()->info('Hello, World!');
    chrome_log()->info('session', $_SESSION);

    return [200, [], view('index')];
}];

$routes['acct'] = ['GET', '/acct/:acct', function (Action $action) {
    chrome_log()->info('session', $_SESSION);

    $acct_input = $action->param['acct'];

    if (!isset($_SESSION['mastodons'][$acct_input])) {
        set_flash(['error' => "Not logged in: {$acct_input}"]);
        return [302, ['Location' => '/'], null];
    };

    return [200, [], view('acct', [
        'acct' => $acct_input,
    ])];
}, ['acct' => RE_ACCT]];

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

    if (strpos($instance, 'localhost:') === 0 || strpos($instance, '0.0.0.0:') === 0) {
        $instance = "http://{$instance}";
    }

    $client = new m\Client($instance, ['name' => SERVICE_NAME]);
    $scope = m\scope('read write follow');
    $callback_url = app\get_service_base_url(router()->makePath('auth_callback'));
    $state = bin2hex(random_bytes(8));

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

    $_SESSION['login'][$state] = [
        'instance' => $instance,
        'acct' => $acct,
        'expire' => time() + 600,
    ];
    chrome_log()->info("redirect", ['state' => $state, 'session' => $_SESSION]);

    //$_SESSION['mastodons'][$instance] = [];
    $auth = new m\Service\AuthFactory($client, $app['client_id'], $app['client_secret']);

    $redirect_url = m\Grant\CodeGrant::getRedirectUrl($client, $auth, $scope, $callback_url, $state);
    return [302, ['Location' => $redirect_url], null];
}];

$routes['auth_callback'] = ['GET', '/auth/callback', function (Action $action) {
    $code_input  = filter_input(INPUT_GET, 'code',  FILTER_DEFAULT);
    $state_input = filter_input(INPUT_GET, 'state', FILTER_DEFAULT);

    if (!isset($_SESSION['login'], $_SESSION['login'][$state_input]) || !is_array($_SESSION['login'][$state_input])) {
        set_flash(['error' => "invalid login flow."]);
        return [302, ['Location' => '/'], null];
    }

    $instance = $_SESSION['login'][$state_input];
    $client = new m\Client($instance['instance'], ['name' => SERVICE_NAME]);
    $scope = m\scope('read write follow');
    $callback_url = app\get_service_base_url(router()->makePath('auth_callback'));

    try {
        $app = app\get_client_app($client, $scope, [$callback_url]);
    } catch (\Exception $e) {
        throw $e;
        set_flash(['error' => $e->getMessage()]);
        return [302, ['Location' => '/'], null];
    }

    $grant = new CodeGrant($code_input, $callback_url);
    $auth_factory = new AuthFactory($client, $app['client_id'], $app['client_secret']);
    $auth_factory->setGrant($grant);

    try {
        $auth = $auth_factory->authorize($scope);
    } catch (\Exception $e) {
        throw $e;
        set_flash(['error' => $e->getMessage()]);
        return [302, ['Location' => '/'], null];
    }

    $_SESSION['mastodons'][$instance['acct']] = [
        'access_token' => $auth->access_token,
        'token_type'   => $auth->token_type,
        'scope'        => (string)$auth->scope,
        'created_at'   => $auth->created_at,
    ];

    unset($_SESSION['login'][$state_input]);

    return [302, ['Location' => '/'], null];
}];

$routes['#404'] = function (Action $action) {
    return [404, [], view('404')];
};

return $routes;
