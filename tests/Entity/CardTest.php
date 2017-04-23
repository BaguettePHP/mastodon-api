<?php

namespace Baguette\Mastodon\Entity;

/**
 * Card
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#card
 */
class CardTest extends \Baguette\Mastodon\TestCase
{
    /**
     * @dataProvider dataProviderFor_test
     */
    public function test(array $input, array $expected)
    {
        $actual = new Card($input);

        $this->assertEquals(isset($input['url'])   ? $input['url']   : null, $actual->url);
        $this->assertEquals(isset($input['title']) ? $input['title'] : null, $actual->title);
        $this->assertEquals(isset($input['description']) ? $input['description'] : null, $actual->description);

        $this->assertEquals($expected['toArray'], toArrayValue($actual));
    }

    public function dataProviderFor_test()
    {
        return [
            [
                'input' => [],
                'expected' => [
                    'toArray' => [
                        'url'   => null,
                        'title' => null,
                        'description' => null,
                    ],
                ],
            ],
            [
                'input' => [
                    'url'   => 'a',
                    'title' => 'b',
                    'description' => 'c',
                ],
                'expected' => [
                    'toArray' => [
                        'url'   => 'a',
                        'title' => 'b',
                        'description' => 'c',
                    ],
                ],
            ],
        ];
    }
}
