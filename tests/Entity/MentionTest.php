<?php

namespace Baguette\Mastodon\Entity;

/**
 * Mention
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#tag
 */
class MentionTest extends \Baguette\Mastodon\TestCase
{
    /**
     * @dataProvider dataProviderFor_test
     */
    public function test(array $input, array $expected)
    {
        $actual = new Mention($input);

        $this->assertEquals(isset($input['url'])      ? $input['url']      : null, $actual->url);
        $this->assertEquals(isset($input['username']) ? $input['username'] : null, $actual->username);
        $this->assertEquals(isset($input['acct'])     ? $input['acct']     : null, $actual->acct);
        $this->assertEquals(isset($input['id'])       ? $input['id']       : null, $actual->id);

        $this->assertEquals($expected['toArray'], toArrayValue($actual));
    }

    public function dataProviderFor_test()
    {
        return [
            [
                'input' => [],
                'expected' => [
                    'toArray' => [
                        'url'      => null,
                        'username' => null,
                        'acct'     => null,
                        'id'       => null,
                    ],
                ],
            ],
            [
                'input' => [
                        'url'      => 'a',
                        'username' => 'b',
                        'acct'     => 'c',
                        'id'       => 12345,
                ],
                'expected' => [
                    'toArray' => [
                        'url'      => 'a',
                        'username' => 'b',
                        'acct'     => 'c',
                        'id'       => 12345,
                    ],
                ],
            ],
        ];
    }
}
