<?php
namespace Baguette\Mastodon\Entity;

/**
 * Status
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#status
 */
class StatusTest extends \Baguette\Mastodon\TestCase
{
    /**
     * @dataProvider dataProviderFor_test
     */
    public function test(array $input, array $expected)
    {
        $actual = new Status($input);

        $this->assertEquals(isset($input['id'])      ? $input['id']      : null, $actual->id);
        $this->assertEquals(isset($input['uri'])     ? $input['uri']     : null, $actual->uri);
        $this->assertEquals(isset($input['url'])     ? $input['url']     : null, $actual->url);
        $this->assertEquals(isset($input['account']) ? $input['account'] : null, $actual->account);
        $this->assertEquals(isset($input['in_reply_to_id'])         ? $input['in_reply_to_id'] : null, $actual->in_reply_to_id);
        $this->assertEquals(isset($input['in_reply_to_account_id']) ? $input['in_reply_to_account_id'] : null, $actual->in_reply_to_account_id);
        $this->assertEquals(isset($input['reblog'])     ? $input['reblog']     : null, $actual->reblog);
        $this->assertEquals(isset($input['content'])    ? $input['content']    : null, $actual->content);
        $this->assertEquals(isset($input['created_at']) ? new \DateTimeImmutable($input['created_at']) : null, $actual->created_at);
        $this->assertEquals(isset($input['reblogs_count'])    ? $input['reblogs_count']    : null, $actual->reblogs_count);
        $this->assertEquals(isset($input['favourites_count']) ? $input['favourites_count'] : null, $actual->favourites_count);
        $this->assertEquals(isset($input['reblogged'])    ? $input['reblogged']    : null, $actual->reblogged);
        $this->assertEquals(isset($input['favourited'])   ? $input['favourited']   : null, $actual->favourited);
        $this->assertEquals(isset($input['sensitive'])    ? $input['sensitive']    : null, $actual->sensitive);
        $this->assertEquals(isset($input['spoiler_text']) ? $input['spoiler_text'] : null, $actual->spoiler_text);
        $this->assertEquals(isset($input['visibility'])   ? $input['visibility']   : null, $actual->visibility);
        $this->assertEquals(isset($input['media_attachments']) ? $input['media_attachments'] : null, $actual->media_attachments);
        $this->assertEquals(isset($input['mentions'])    ? $input['mentions']    : null, $actual->mentions);
        $this->assertEquals(isset($input['tags'])        ? $input['tags']        : null, $actual->tags);
        $this->assertEquals(isset($input['application']) ? $input['application'] : null, $actual->application);

        $this->assertEquals($expected['toArray'], toArrayValue($actual));
    }

    public function dataProviderFor_test()
    {
        $empty_status = [
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
        ];

        return [
            [
                'input' => [],
                'expected' => [
                    'toArray' => $empty_status,
                ],
            ],
            [
                'input' => [
                    'id'                => 12345,
                    'uri'               => 'a',
                    'url'               => 'b',
                    'account'           => new Account([]),
                    'in_reply_to_id'    => 56789,
                    'in_reply_to_account_id' => 23456,
                    'reblog'            => new Status([]),
                    'content'           => 'd',
                    'created_at'        => '2112-09-03T09:00:00Z',
                    'reblogs_count'     => 1,
                    'favourites_count'  => 2,
                    'reblogged'         => false,
                    'favourited'        => false,
                    'sensitive'         => true,
                    'spoiler_text'      => 'e',
                    'visibility'        => 'public',
                    'media_attachments' => [new Attachment([])],
                    'mentions'          => [new Mention([])],
                    'tags'              => [new Tag([])],
                    'application'       => new Application([]),
                ],
                'expected' => [
                    'toArray' => [
                        'id'                => 12345,
                        'uri'               => 'a',
                        'url'               => 'b',
                        'account'           => [
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
                        'in_reply_to_id'    => 56789,
                        'in_reply_to_account_id' => 23456,
                        'reblog'            => $empty_status,
                        'content'           => 'd',
                        'created_at'        => '2112-09-03T09:00:00+00:00',
                        'reblogs_count'     => 1,
                        'favourites_count'  => 2,
                        'reblogged'         => false,
                        'favourited'        => false,
                        'sensitive'         => true,
                        'spoiler_text'      => 'e',
                        'visibility'        => 'public',
                        'media_attachments' => [
                            [
                                'id'          => null,
                                'type'        => null,
                                'url'         => null,
                                'remote_url'  => null,
                                'preview_url' => null,
                                'text_url'    => null,
                            ]
                        ],
                        'mentions' => [
                            [
                                'url' => null,
                                'username' => null,
                                'acct' => null,
                                'id' => null,
                            ]
                        ],
                        'tags' => [
                            [
                                'name' => null,
                                'url'  => null,
                            ]
                        ],
                        'application' => [
                            'name'    => null,
                            'website' => null,
                        ],
                    ],
                ],
            ],
        ];
    }
}
