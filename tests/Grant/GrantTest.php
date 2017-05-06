<?php

namespace Baguette\Mastodon\Grant;

use Baguette\Mastodon\Client as MastodonClient;
use Baguette\Mastodon\Service\AuthFactory;

/**
 * Abstract grant class
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
class GrantTest extends \Baguette\Mastodon\TestCase
{
    public function test_getPathToOAuthToken()
    {
        $expected = 'https://example.com/oauth/token';

        $client = new MastodonClient('example.com');

        $this->assertEquals($expected, DummyGrant::getPathToOAuthToken($client));
    }

    public function test_getFormParams()
    {
        $expected = [
            'client_id'     => 'qawsedrftgyhujikolp',
            'client_secret' => 'zxcvbnmasdfghjklpoi',
        ];

        $client_id     = 'qawsedrftgyhujikolp';
        $client_secret = 'zxcvbnmasdfghjklpoi';
        $factory = new AuthFactory(new MastodonClient('example.com'), $client_id, $client_secret);

        $this->assertEquals($expected, DummyGrant::getFormParams($factory));
    }
}
