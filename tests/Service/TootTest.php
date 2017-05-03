<?php

namespace Baguette\Mastodon\Service;

/**
 * Toot
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
class TootTest extends \Baguette\Mastodon\TestCase
{
    /**
     * @dataProvider dataProviderFor_test
     */
    public function test($toot_string, array $options)
    {
        $actual = new Toot($toot_string, $options);

        $this->assertSame($toot_string, $actual->toot_string);
        $this->assertEquals(isset($options['media_ids'])      ? $options['media_ids']      : [],   $actual->media_ids);
        $this->assertEquals(isset($options['in_reply_to_id']) ? $options['in_reply_to_id'] : null, $actual->in_reply_to_id);
        $this->assertEquals(isset($options['visibility'])     ? $options['visibility']     : null, $actual->visibility);
        $this->assertEquals(isset($options['sensitive'])      ? $options['sensitive']      : null, $actual->sensitive);
    }

    public function dataProviderFor_test()
    {
        return [
            [
                'toot_string' => 'a',
                'options' => [],
            ],
        ];
    }
}
