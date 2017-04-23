<?php

namespace Baguette\Mastodon\Entity;

/**
 * Account
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#account
 */
class AccountTest extends \Baguette\Mastodon\TestCase
{
    /**
     * @dataProvider dataProviderFor_test
     */
    public function test(array $input, array $expected)
    {
        $actual = new Account($input);

        $this->assertEquals(isset($input['id'])              ? $input['id']              : null, $actual->id);
        $this->assertEquals(isset($input['username'])        ? $input['username']        : null, $actual->username);
        $this->assertEquals(isset($input['acct'])            ? $input['acct']            : null, $actual->acct);
        $this->assertEquals(isset($input['display_name'])    ? $input['display_name']    : null, $actual->display_name);
        $this->assertEquals(isset($input['locked'])          ? $input['locked']          : null, $actual->locked);
        $this->assertEquals(isset($input['created_at']) ? new \DateTimeImmutable($input['created_at']) : null, $actual->created_at);
        $this->assertEquals(isset($input['followers_count']) ? $input['followers_count'] : null, $actual->followers_count);
        $this->assertEquals(isset($input['following_count']) ? $input['following_count'] : null, $actual->following_count);
        $this->assertEquals(isset($input['statuses_count'])  ? $input['statuses_count']  : null, $actual->statuses_count);
        $this->assertEquals(isset($input['note'])            ? $input['note']            : null, $actual->note);
        $this->assertEquals(isset($input['url'])             ? $input['url']             : null, $actual->url);
        $this->assertEquals(isset($input['avatar'])          ? $input['avatar']          : null, $actual->avatar);
        $this->assertEquals(isset($input['avatar_static'])   ? $input['avatar_static']   : null, $actual->avatar_static);
        $this->assertEquals(isset($input['header'])          ? $input['header']          : null, $actual->header);
        $this->assertEquals(isset($input['header_static'])   ? $input['header_static']   : null, $actual->header_static);

        $this->assertEquals($expected['toArray'], toArrayValue($actual));
    }

    public function dataProviderFor_test()
    {
        return [
            [
                'input' => [],
                'expected' => [
                    'toArray' => [
                        'id'              => null,
                        'username'        => null,
                        'acct'            => null,
                        'display_name'    => null,
                        'locked'          => null,
                        'created_at'      => null,
                        'followers_count' => null,
                        'following_count' => null,
                        'statuses_count'  => null,
                        'note'            => null,
                        'url'             => null,
                        'avatar'          => null,
                        'avatar_static'   => null,
                        'header'          => null,
                        'header_static'   => null,
                    ],
                ],
            ],
            [
                'input' => [
                    'id'              => 1,
                    'username'        => 'a',
                    'acct'            => 'b',
                    'display_name'    => 'c',
                    'locked'          => true,
                    'created_at'      => '2112-09-03T15:52:01Z',
                    'followers_count' => 1,
                    'following_count' => 2,
                    'statuses_count'  => 3,
                    'note'            => 'd',
                    'url'             => 'e',
                    'avatar'          => 'f',
                    'avatar_static'   => 'g',
                    'header'          => 'h',
                    'header_static'   => 'i',
                ],
                'expected' => [
                    'toArray' => [
                        'id'              => 1,
                        'username'        => 'a',
                        'acct'            => 'b',
                        'display_name'    => 'c',
                        'locked'          => true,
                        'created_at'      => '2112-09-03T15:52:01+00:00',
                        'followers_count' => 1,
                        'following_count' => 2,
                        'statuses_count'  => 3,
                        'note'            => 'd',
                        'url'             => 'e',
                        'avatar'          => 'f',
                        'avatar_static'   => 'g',
                        'header'          => 'h',
                        'header_static'   => 'i',
                    ],
                ],
            ],
        ];
    }
}
