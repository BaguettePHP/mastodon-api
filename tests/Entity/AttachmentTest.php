<?php

namespace Baguette\Mastodon\Entity;

/**
 * Attachment
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#attachment
 */
class AttachmentTest extends \Baguette\Mastodon\TestCase
{
    /**
     * @dataProvider dataProviderFor_test
     */
    public function test(array $input, array $expected)
    {
        $actual = new Attachment($input);

        $this->assertEquals(isset($input['id'])   ? $input['id']   : null, $actual->id);
        $this->assertEquals(isset($input['type']) ? $input['type'] : null, $actual->type);
        $this->assertEquals(isset($input['url'])  ? $input['url']  : null, $actual->url);
        $this->assertEquals(isset($input['remote_url'])  ? $input['remote_url']  : null, $actual->remote_url);
        $this->assertEquals(isset($input['preview_url']) ? $input['preview_url'] : null, $actual->preview_url);
        $this->assertEquals(isset($input['text_url'])    ? $input['text_url']    : null, $actual->text_url);

        $this->assertEquals($expected['toArray'], toArrayValue($actual));
    }

    public function dataProviderFor_test()
    {
        return [
            [
                'input' => [],
                'expected' => [
                    'toArray' => [
                        'id'          => null,
                        'type'        => null,
                        'url'         => null,
                        'remote_url'  => null,
                        'preview_url' => null,
                        'text_url'    => null,
                    ],
                ],
            ],
            [
                'input' => [
                    'id'          => 1,
                    'type'        => 'image',
                    'url'         => 'a',
                    'remote_url'  => 'b',
                    'preview_url' => 'c',
                    'text_url'    => 'd',
                ],
                'expected' => [
                    'toArray' => [
                        'id'          => 1,
                        'type'        => 'image',
                        'url'         => 'a',
                        'remote_url'  => 'b',
                        'preview_url' => 'c',
                        'text_url'    => 'd',
                    ],
                ],
            ],
        ];
    }
}
