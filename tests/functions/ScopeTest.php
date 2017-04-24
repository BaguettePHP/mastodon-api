<?php

namespace Baguette\Mastodon\functions;

use Baguette\Mastodon\Service\Scope;

/**
 * scope function
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
class ScopeTest extends \Baguette\Mastodon\TestCase
{
    /**
     * @dataProvider dataProviderFor_test
     */
    public function test($input, Scope $expected)
    {
        $actual = \Baguette\Mastodon\scope($input);

        $this->assertInstanceOf(Scope::class, $actual);
        $this->assertEquals($expected, $actual);
    }

    public function dataProviderFor_test()
    {
        return [
            [
                'input' => 'read write',
                'expected' => new Scope(['read', 'write']),
            ],
        ];
    }
}
