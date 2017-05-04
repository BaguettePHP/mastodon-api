<?php

namespace Baguette\Mastodon\Service;

use Baguette\Mastodon;

/**
 * Noop credential
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
class NoopCredentialTest extends \Baguette\Mastodon\RequesterTestCase
{
    public function test()
    {
        $actual = new NoopCredential();
        $this->assertInstanceOf(Credential::class, $actual);

        return $actual;
    }

    /**
     * @depends test
     * @expectedException \RuntimeException
     */
    public function test_auth_raise_RuntimeException(NoopCredential $actual)
    {
        $actual->auth(Mastodon\http(), $this->auth_factory, Mastodon\scope(''));
    }
}
