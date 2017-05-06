<?php

namespace Baguette\Mastodon\Grant;

use Baguette\Mastodon\Service\AuthFactory;
use Baguette\Mastodon\Service\Scope;
use GuzzleHttp\ClientInterface as Client;

/**
 * Mastodon noop grant class
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
class NoopGrant extends Grant
{
    public function __construct()
    {
        // noop
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
