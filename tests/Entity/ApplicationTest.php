<?php

namespace Baguette\Mastodon\Entity;

/**
 * Application
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#application
 */
class ApplicationTest extends \Baguette\Mastodon\TestCase
{
    /**
     * @dataProvider dataProviderFor_test
     */
    public function test(array $input, array $expected)
    {
        $actual = new Application($input);

        $this->assertEquals(isset($input['name'])    ? $input['name']   : null, $actual->name);
        $this->assertEquals(isset($input['website']) ? $input['website'] : null, $actual->website);

        $this->assertEquals($expected['toArray'], toArrayValue($actual));
    }

    public function dataProviderFor_test()
    {
        return [
            [
                'input' => [],
                'expected' => [
                    'toArray' => [
                        'name'    => null,
                        'website' => null,
                    ],
                ],
            ],
            [
                'input' => [
                    'name'    => 'a',
                    'website' => 'b',
                ],
                'expected' => [
                    'toArray' => [
                        'name'    => 'a',
                        'website' => 'b',
                    ],
                ],
            ],
        ];
    }
}
