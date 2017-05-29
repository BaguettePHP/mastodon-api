<?php

/**
 * Mastodon SampleApp application functions
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */

namespace app
{
    use Baguette\Mastodon as m;
    use Respect\Validation\Validator as v;

    /**
     * @return void
     */
    function gc_session()
    {
        $now = time();

        $_SESSION['login'] = isset($_SESSION['login']) ? $_SESSION['login'] : [];
        $_SESSION['mastodons'] = isset($_SESSION['mastodons']) ? $_SESSION['mastodons'] : [];

        foreach ($_SESSION['login'] as $k => $v) {
            if (empty($v['expire']) || $v['expire'] < $now) {
                unset($_SESSION['login'][$k]);
            }
        }

        if (isset($_SESSION['_flash'])) {
            last_flash($_SESSION['_flash']);
        }

        $_SESSION['_flash'] = [];
    }

    /**
     * @param  m\Client $client
     * @param  m\Service\Scope $scope
     * @param  string[] $callback_uris
     * @param  string
     * @return array
     */
    function get_client_app(m\Client $client, m\Service\Scope $scope, array $callback_uris)
    {
        $file = strtr($client->getHostname(), ['/' => '_']);
        $path = __DIR__ . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, ['..', 'cache', "{$file}.json"]);

        $callback_uri = array_shift($callback_uris);
        if (count($callback_uris) > 0) {
            trigger_error('Current Mastodon API does not accept multiple redirect_uri.', E_USER_NOTICE);
        }

        if (is_file($path)) {
            $app = file_get_contents($path);
        } else {
            $create_app_path = sprintf('%s://%s/api/v1/apps', $client->getScheme(), $client->getHostname());
            $request_options = [
                'form_params' => [
                    'client_name' => \SERVICE_NAME . " ip",
                    'scope' => (string)$scope,
                    'redirect_uris' => $callback_uri,
                ]
            ];

            chrome_log()->info('request', [
                'method' => 'POST',
                'uri' => $create_app_path,
                'options' => $request_options,
            ]);

            $response = m\http()->request('POST', $create_app_path, $request_options);
            $app = (string)$response->getBody();

            app_log()->debug('create_app', ['app' => $app]);

            file_put_contents($path, $app);
        }

        return \GuzzleHttp\json_decode($app, true);
    }

    /**
     * @return string
     */
    function get_service_base_url($callback_url_path)
    {
        return implode('/', [
            rtrim(getenv('SERVICE_BASE_URL'), '/'),
            ltrim($callback_url_path, '/')
        ]);
    }
}
