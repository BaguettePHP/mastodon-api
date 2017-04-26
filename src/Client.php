<?php

namespace Baguette\Mastodon;

use Baguette\Mastodon;
use Baguette\Mastodon\Service\SessionStorage;
use Psr\Http\Message\ResponseInterface;

/**
 * Mastodon API Client
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
final class Client
{
    const USER_AGENT = 'PhpMastodon/0.0.1(+https://github.com/zonuexe/php-mastodon-client)';

    /** @var string */
    private $instance;
    /** @var string|null */
    private $client_name;
    /** @var \GuzzleHttp\Client */
    private $api_http_client;
    /** @var \GuzzleHttp\Client */
    private $oauth_http_client;

    /**
     * @param string $instance
     * @param array  $options
     */
    public function __construct($instance, array $options = [])
    {
        $this->instance = $instance;

        if (isset($options['client_name'])) {
            $this->client_name = $options['client_name'];
        }
    }

    /**
     * @param  string $method "GET"|"POST"
     * @param  string $path
     * @param  array  $options
     * @param  SessionStorage $session
     * @return ResponseInterface
     */
    public function requestAPI($method, $path, array $options, SessionStorage $session)
    {
        $request_options = $options + $this->getRequestAPIOptions($session);

        return $this->getAPIHttpClient()->request($method, $path, $request_options);
    }

    /**
     * @return \GuzzleHttp\Client
     */
    private function getAPIHttpClient()
    {
        if (empty($this->api_http_client)) {
            $this->api_http_client = new \GuzzleHttp\Client([
                'base_uri' => sprintf('%s://%s', $this->getScheme(), $this->getHostname()),
            ]);
        }

        return $this->api_http_client;
    }

    /**
     * @param  SessionStorage $session
     * @return array
     */
    private function getRequestAPIOptions(SessionStorage $session)
    {
        if (isset($this->client_name)) {
            $user_agent = sprintf('%s; %s; %s', self::USER_AGENT, $this->client_name, \GuzzleHttp\default_user_agent());
        } else {
            $user_agent = sprintf('%s; %s', self::USER_AGENT, \GuzzleHttp\default_user_agent());
        }

        return [
            'headers' => [
                'Authorization' => "Bearer {$session->getAccessToken()}",
                'User-Agent'    => $user_agent,
            ],
         ];
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return parse_url($this->instance, PHP_URL_SCHEME) ?: 'https';
    }

    /**
     * @return string
     */
    public function getHostname()
    {
        return parse_url($this->instance, PHP_URL_HOST) ?: $this->instance;
    }
}
