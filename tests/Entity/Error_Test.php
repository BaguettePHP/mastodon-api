<?php

namespace Baguette\Mastodon\Entity;

/**
 * Error
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
class Error_Test extends \Baguette\Mastodon\TestCase
{
    /**
     * @dataProvider dataProviderFor_test
     */
    public function test(array $input, array $expected)
    {
        $actual = new Error_($input);

        $this->assertEquals(isset($input['error']) ? $input['error'] : null, $actual->error);

        $this->assertEquals($expected['toArray'], toArrayValue($actual));
    }

    public function dataProviderFor_test()
    {
        return [
            [
                'input' => [],
                'expected' => [
                    'toArray' => [
                        'error' => null,
                    ],
                ],
            ],
            [
                'input' => [
                    'error' => 'a',
                ],
                'expected' => [
                    'toArray' => [
                        'error' => 'a',
                    ],
                ],
            ],
        ];
    }
}
