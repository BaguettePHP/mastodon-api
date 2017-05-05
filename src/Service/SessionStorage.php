<?php

namespace Baguette\Mastodon\Service;

use Baguette\Mastodon;
use Baguette\Mastodon\Service;

/**
 * Mastodon Anthorization object factory
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
class SessionStorage
{
    use \Teto\Object\PrivateGetter;

    /** @var AuthFactory */
    private $auth_factory;
    /** @var Scope */
    private $scope;
    /** @var Authorization */
    private $authorization;

    /**
     * @param AuthFactory $auth_factory
     * @param Scope       $scope
     */
    public function __construct(AuthFactory $auth_factory, Scope $scope)
    {
        $this->auth_factory = $auth_factory;
        $this->scope = $scope;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        if ($this->authorization === null) {
            $this->authorize();
        }

        return $this->authorization->access_token;
    }

    /**
     * @return Authorization
     */
    public function authorize()
    {
        $this->authorization = $this->auth_factory->authorize($this->scope);

        return $this->authorization;
    }

    /**
     * @param  Authorization $authorization
     * @return void
     */
    public function setAuthorization(Authorization $authorization)
    {
        $this->authorization = $authorization;
    }
}
