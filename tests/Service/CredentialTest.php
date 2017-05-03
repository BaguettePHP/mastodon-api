<?php

namespace Baguette\Mastodon\Service;

use Baguette\Mastodon\Client as MastodonClient;

/**
 * Abstract credential
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
class CredentialTest extends \Baguette\Mastodon\TestCase
{
    public function test_getPathToOAuthToken()
    {
        $expected = 'https://example.com/oauth/token';

        $client = new MastodonClient('example.com');

        $this->assertEquals($expected, DummyCredential::getPathToOAuthToken($client));
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

        $this->assertEquals($expected, DummyCredential::getFormParams($factory));
    }
}
