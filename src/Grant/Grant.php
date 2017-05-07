<?php

namespace Baguette\Mastodon\Grant;

use Baguette\Mastodon\Client as MastodonClient;
use Baguette\Mastodon\Service\AuthFactory;
use Baguette\Mastodon\Service\Scope;
use GuzzleHttp\ClientInterface as GuzzleHttpClient;

/**
 * Mastodon grant request class
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
abstract class Grant
{
    /**
     * @param Client      $http
     * @param AuthFactory $factory
     * @param Scope       $scope
     */
    abstract public function auth(GuzzleHttpClient $http, AuthFactory $factory, Scope $scope);

    /**
     * @return string
     */
    protected static function getPathToOAuthToken(MastodonClient $client)
    {
        return sprintf('%s://%s/oauth/token', $client->getScheme(), $client->getHostname());
    }

    /**
     * @return array
     */
    protected static function getFormParams(AuthFactory $factory)
    {
        return [
            'client_id'     => $factory->client_id,
        ];
    }

    /**
     * @return array
     */
    protected static function getFormParamsWithSecret(AuthFactory $factory)
    {
        return $this->getFormParams($factory) + [
            'client_secret' => $factory->client_secret,
        ];
    }
}
