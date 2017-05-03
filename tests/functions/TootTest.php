<?php

namespace Baguette\Mastodon\functions;

use Baguette\Mastodon\Service\Toot;

/**
 * toot function
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
class TootTest extends \Baguette\Mastodon\TestCase
{
    /**
     * @dataProvider dataProviderFor_test
     */
    public function test($toot_string, array $options, Toot $expected)
    {
        $actual = \Baguette\Mastodon\toot($toot_string, $options);

        $this->assertInstanceOf(Toot::class, $actual);
        $this->assertEquals($expected, $actual);
    }

    public function dataProviderFor_test()
    {
        return [
            [
                'toot_string' => 'a',
                'options' => [],
                'expected' => new Toot('a', []),
            ],
        ];
    }
}
