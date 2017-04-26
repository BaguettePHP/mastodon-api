<?php

namespace Baguette\Mastodon\Service;

use GuzzleHttp\Client;

class PasswordCredential extends Credential
{
    /** @var string */
    private $username;
    /** @var string */
    private $password;

    /**
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @param Client      $http
     * @param AuthFactory $factory
     * @param Scope       $scope
     */
    public function auth(Client $http, AuthFactory $factory, Scope $scope)
    {
        return $http->request('POST', static::getPathToOAuthToken($factory->client), [
            'form_params' => [
                'grant_type' => 'password',
                'username' => $this->username,
                'password' => $this->password,
                'scope' => (string)$scope,
            ] + static::getFormParams($factory),
        ]);
    }
}
