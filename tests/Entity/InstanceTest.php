<?php

namespace Baguette\Mastodon\Entity;

/**
 * Instance
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#instance
 */
class InstanceTest extends \Baguette\Mastodon\TestCase
{
    /**
     * @dataProvider dataProviderFor_test
     */
    public function test(array $input, array $expected)
    {
        $actual = new Instance($input);

        $this->assertEquals(isset($input['title']) ? $input['title'] : null, $actual->title);
        $this->assertEquals(isset($input['uri'])  ? $input['uri']  : null, $actual->uri);
        $this->assertEquals(isset($input['description']) ? $input['description'] : null, $actual->description);
        $this->assertEquals(isset($input['email'])  ? $input['email']  : null, $actual->email);

        $this->assertEquals($expected['toArray'], toArrayValue($actual));
    }

    public function dataProviderFor_test()
    {
        return [
            [
                'input' => [],
                'expected' => [
                    'toArray' => [
                        'uri'          => null,
                        'title'        => null,
                        'description'  => null,
                        'email'        => null,
                    ],
                ],
            ],
            [
                'input' => [
                    'uri'          => 'a',
                    'title'        => 'b',
                    'description'  => 'c',
                    'email'        => 'e',
                ],
                'expected' => [
                    'toArray' => [
                        'uri'          => 'a',
                        'title'        => 'b',
                        'description'  => 'c',
                        'email'        => 'e',
                    ],
                ],
            ],
        ];
    }
}
