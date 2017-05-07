<?php

namespace Baguette\Mastodon\Grant;

use Baguette\Mastodon\Service\AuthFactory;
use Baguette\Mastodon\Service\Scope;
use GuzzleHttp\ClientInterface as Client;

/**
 * Mastodon password credential grant
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
class PasswordCredential extends Grant
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
     * @param  Client      $http
     * @param  AuthFactory $factory
     * @param  Scope       $scope
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function auth(Client $http, AuthFactory $factory, Scope $scope)
    {
        return $http->request('POST', static::getPathToOAuthToken($factory->client), [
            'form_params' => [
                'grant_type' => 'password',
                'username' => $this->username,
                'password' => $this->password,
                'scope' => (string)$scope,
            ] + static::getFormParamsWithSecret($factory),
        ]);
    }
}
