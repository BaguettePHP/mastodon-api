<?php

namespace Baguette\Mastodon\Entity;

/**
 * Tag
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#tag
 */
class TagTest extends \Baguette\Mastodon\TestCase
{
    /**
     * @dataProvider dataProviderFor_test
     */
    public function test(array $input, array $expected)
    {
        $actual = new Tag($input);

        $this->assertEquals(isset($input['name']) ? $input['name'] : null, $actual->name);
        $this->assertEquals(isset($input['url'])  ? $input['url']  : null, $actual->url);

        $this->assertEquals($expected['toArray'], toArrayValue($actual));
    }

    public function dataProviderFor_test()
    {
        return [
            [
                'input' => [],
                'expected' => [
                    'toArray' => [
                        'name' => null,
                        'url'  => null,
                    ],
                ],
            ],
            [
                'input' => [
                    'name' => 'a',
                    'url'  => 'b',
                ],
                'expected' => [
                    'toArray' => [
                        'name' => 'a',
                        'url'  => 'b',
                    ],
                ],
            ],
        ];
    }
}
