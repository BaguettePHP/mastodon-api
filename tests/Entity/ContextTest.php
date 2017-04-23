<?php

namespace Baguette\Mastodon\Entity;

/**
 * Context
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#context
 */
class ContextTest extends \Baguette\Mastodon\TestCase
{
    /**
     * @dataProvider dataProviderFor_test
     */
    public function test(array $input, array $expected)
    {
        $actual = new Context($input);

        $this->assertEquals(isset($input['ancestors'])   ? $input['ancestors']   : null, $actual->ancestors);
        $this->assertEquals(isset($input['descendants']) ? $input['descendants'] : null, $actual->descendants);

        $this->assertEquals($expected['toArray'], toArrayValue($actual));
    }

    public function dataProviderFor_test()
    {
        return [
            [
                'input' => [],
                'expected' => [
                    'toArray' => [
                        'ancestors'   => null,
                        'descendants' => null,
                    ],
                ],
            ],
            [
                'input' => [
                    'ancestors'   => [],
                    'descendants' => [],
                ],
                'expected' => [
                    'toArray' => [
                        'ancestors'   => [],
                        'descendants' => [],
                    ],
                ],
            ],
        ];
    }
}
