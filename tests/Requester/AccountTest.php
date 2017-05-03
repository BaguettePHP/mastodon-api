<?php

namespace Baguette\Mastodon;

use GuzzleHttp\Handler\MockHandler;

/**
 * Requester Account Test
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md
 */
class AccountTest extends RequesterTestCase
{
    public function test_getAccount()
    {
        $this->addHttpMockResponse(200, [], json_encode([
            'id' => 12345,
            'username' => 'john',
            'acct' => 'john@mstdn.example.com',
            'display_name' => 'John',
            'locked' => false,
            'created_at' => '2112-09-03T15:52:01+00:00',
            'followers_count' => 12,
            'following_count' => 34,
            'statuses_count'  => 56,
            'note'            => 'd',
            'url'             => 'https://example.com/',
            'avatar'          => 'f',
            'avatar_static'   => 'g',
            'header'          => 'h',
            'header_static'   => 'i',
        ]));

        $actual = Requester::getAccount($this->client, $this->getSession(), 12345);

        $this->assertInstanceOf(Entity\Account::class, $actual);
    }
}
