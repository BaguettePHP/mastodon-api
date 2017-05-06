<?php

namespace Baguette\Mastodon\functions;

use Baguette\Mastodon;
use Baguette\Mastodon\Service\SessionStorage;

/**
 * session function
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
class SessionTest extends \Baguette\Mastodon\TestCase
{
    public function test()
    {
        $actual = \Baguette\Mastodon\session(
            'mstdn.example.social',
            'xxxxxxxx', 'yyyyyyyy',
            [
                'scope' => 'read',
                'grant' => [
                    'username' => 'sample',
                    'password' => 'xyzxyz',
                ],
                'authorization' => [
                    'access_token' => 'zzzzzzzzz',
                    'token_type'   => 'bearer',
                    'scope'        => 'read',
                    'created_at'   => 123456789,
                ],
            ]
        );

        $this->assertInstanceOf(Mastodon\Mastodon::class, $actual);
        $this->assertInstanceOf(Mastodon\Client::class, $actual->client);
        $this->assertInstanceOf(SessionStorage::class, $actual->session);
    }
}
