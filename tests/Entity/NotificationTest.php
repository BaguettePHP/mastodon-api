<?php

namespace Baguette\Mastodon\Entity;

/**
 * Notification
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#tag
 */
class NotificationTest extends \Baguette\Mastodon\TestCase
{
    /**
     * @dataProvider dataProviderFor_test
     */
    public function test(array $input, array $expected)
    {
        $actual = new Notification($input);

        $this->assertEquals(isset($input['id'])   ? $input['id']   : null, $actual->id);
        $this->assertEquals(isset($input['type']) ? $input['type'] : null, $actual->type);
        $this->assertEquals(isset($input['created_at']) ? new \DateTimeImmutable($input['created_at']) : null, $actual->created_at);
        $this->assertEquals(isset($input['account']) ? $input['account'] : null, $actual->account);
        $this->assertEquals(isset($input['status'])  ? $input['status']  : null, $actual->status);

        $this->assertEquals($expected['toArray'], toArrayValue($actual));
    }

    public function dataProviderFor_test()
    {
        return [
            [
                'input' => [],
                'expected' => [
                    'toArray' => [
                        'id'         => null,
                        'type'       => null,
                        'created_at' => null,
                        'account'    => null,
                        'status'     => null,
                    ],
                ],
            ],
            [
                'input' => [
                    'id'         => 12345,
                    'type'       => 'mention',
                    'created_at' => '2112-09-03T09:00:00Z',
                    'account'    => new Account([]),
                    'status'     => new Status([]),
                ],
                'expected' => [
                    'toArray' => [
                        'id'         => 12345,
                        'type'       => 'mention',
                        'created_at' => '2112-09-03T09:00:00+00:00',
                        'account'    => [
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
                        'status'     => [
                            'id'                => null,
                            'uri'               => null,
                            'url'               => null,
                            'account'           => null,
                            'in_reply_to_id'    => null,
                            'in_reply_to_account_id' => null,
                            'reblog'            => null,
                            'content'           => null,
                            'created_at'        => null,
                            'reblogs_count'     => null,
                            'favourites_count'  => null,
                            'reblogged'         => null,
                            'favourited'        => null,
                            'sensitive'         => null,
                            'spoiler_text'      => null,
                            'visibility'        => null,
                            'media_attachments' => null,
                            'mentions'          => null,
                            'tags'              => null,
                            'application'       => null,
                        ],
                    ],
                ],
            ],
        ];
    }
}
