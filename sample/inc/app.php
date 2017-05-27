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

    /**
     * @param  m\Client $client
     * @param  m\Service\Scope $scope
     * @param  string[] $callback_uris
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

            $response = m\http()->request('POST', $create_app_path, $request_options);
            $app = (string)$response->getBody();
            file_put_contents($path, $app);
        }

        return \GuzzleHttp\json_decode($app, true);
    }

    /**
     * @return string
     */
    function get_service_base_url()
    {
        return rtrim(getenv('SERVICE_BASE_URL'), '/');
    }
}
