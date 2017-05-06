<?php

namespace Baguette\Mastodon\Service;

use Baguette\Mastodon;
use Baguette\Mastodon\Client;
use Baguette\Mastodon\Grant\Grant;

/**
 * Mastodon Anthorization object factory
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @property-read Client     $client
 * @property-read string     $client_id
 * @property-read string     $client_secret
 * @property-read Grant      $grant
 * @property-read Scope      $scope
 */
class AuthFactory
{
    use \Teto\Object\PrivateGetter;

    /** @var Client */
    private $client;
    /** @var string */
    private $client_id;
    /** @var string */
    private $client_secret;
    /** @var Grant */
    private $grant;

    /**
     * @param Client $client
     * @param string $client_id
     * @param string $client_secret
     */
    public function __construct(Client $client, $client_id, $client_secret)
    {
        $this->client = $client;
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
    }

    /**
     * @param Grant $grant
     */
    public function setGrant(Grant $grant)
    {
        $this->grant = $grant;
    }

    /**
     * @return Authorization
     */
    public function authorize(Scope $scope)
    {
        $res = $this->grant->auth(Mastodon\http(), $this, $scope);

        if ($res->getStatusCode() !== 200) {
            throw new AuthorizationException;
        }

        return Authorization::fromObject(\GuzzleHttp\json_decode($res->getBody()));
    }
}
