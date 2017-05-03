<?php

namespace Baguette\Mastodon\Service;

use GuzzleHttp\ClientInterface as Client;

class NoopCredential extends Credential
{
    public function __construct()
    {
    }

    /**
     * @param Client      $http
     * @param AuthFactory $factory
     * @param Scope       $scope
     */
    public function auth(Client $http, AuthFactory $factory, Scope $scope)
    {
        throw new \RuntimeException(sprintf('%s cannot authorize.', __CLASS__));
    }
}
