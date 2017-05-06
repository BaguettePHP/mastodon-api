<?php

namespace Baguette\Mastodon\Grant;

use Baguette\Mastodon;

/**
 * Noop grant
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
class NoopGrantTest extends \Baguette\Mastodon\RequesterTestCase
{
    public function test()
    {
        $actual = new NoopGrant();
        $this->assertInstanceOf(Grant::class, $actual);

        return $actual;
    }

    /**
     * @depends test
     * @expectedException \RuntimeException
     */
    public function test_auth_raise_RuntimeException(NoopGrant $actual)
    {
        $actual->auth(Mastodon\http(), $this->auth_factory, Mastodon\scope(''));
    }
}
