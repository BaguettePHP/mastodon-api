<?php

namespace Baguette\Mastodon\Entity;

/**
 * Helper functions for Mastodon API Entity
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
class helpersTest extends \Baguette\Mastodon\TestCase
{
    /**
     * @dataProvider dataProviderFor_test_toArrayValue
     */
    public function test_toArrayValue($input, $expected)
    {
        $this->assertEquals($expected, $input);
    }

    public function dataProviderFor_test_toArrayValue()
    {
        return [
            [null,  null],
            [1,     1],
            ['a',   'a'],
            [[],    []],
            [['a'], ['a']],
        ];
    }
}
