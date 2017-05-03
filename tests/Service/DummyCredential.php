<?php

namespace Baguette\Mastodon\Service;

use Baguette\Mastodon\Client as MastodonClient;
use GuzzleHttp\ClientInterface as GuzzleHttpClient;

/**
 * Dummy credential for test
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
final class DummyCredential extends Credential
{
    /**
     * @param  Client      $http
     * @param  AuthFactory $factory
     * @param  Scope       $scope
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function auth(GuzzleHttpClient $http, AuthFactory $factory, Scope $scope)
    {
        return new \GuzzleHttp\Psr7\Response;
    }

    public static function getPathToOAuthToken(MastodonClient $client)
    {
        return parent::getPathToOAuthToken($client);
    }

    public static function getFormParams(AuthFactory $factory)
    {
        return parent::getFormParams($factory);
    }
}
