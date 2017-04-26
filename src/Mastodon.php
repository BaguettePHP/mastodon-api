<?php

namespace Baguette\Mastodon;

use Baguette\Mastodon\Service\SessionStorage;

/**
 * Mastodon Service
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @method Entity\Account fetchAccount(int $id)
 */
final class Mastodon
{
    /** @var Client */
    private $client;
    /** @var SessionStorage */
    private $session;

    public function __construct(Client $client, SessionStorage $session)
    {
        $this->client = $client;
        $this->session = $session;
    }

    /**
     * @return Entity\Entity
     */
    public function __call($name, array $args)
    {
        return call_user_func_array(
            [Requester::class, $name],
            array_merge([$this->client, $this->session], $args)
        );
    }
}
