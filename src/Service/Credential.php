<?php

namespace Baguette\Mastodon\Service;

use Baguette\Mastodon\Client as MastodonClient;
use GuzzleHttp\ClientInterface as GuzzleHttpClient;

abstract class Credential
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
            'client_secret' => $factory->client_secret,
        ];
    }

}
