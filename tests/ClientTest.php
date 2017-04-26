<?php

namespace Baguette\Mastodon;

/**
 * Tag
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#tag
 */
class ClientTest extends \Baguette\Mastodon\TestCase
{
    /**
     * @dataProvider dataProviderFor_test
     */
    public function test($input, array $expected)
    {
        $actual = new Client($input);

        $this->assertEquals($expected['scheme'],   $actual->getScheme());
        $this->assertEquals($expected['hostname'], $actual->getHostname());
    }

    public function dataProviderFor_test()
    {
        return [
            [
                'input' => 'example.com',
                'expected' => [
                    'scheme'   => 'https',
                    'hostname' => 'example.com',
                ],
            ],
            [
                'input' => 'https://example.com',
                'expected' => [
                    'scheme'   => 'https',
                    'hostname' => 'example.com',
                ],
            ],
            [
                'input' => 'http://example.com',
                'expected' => [
                    'scheme'   => 'http',
                    'hostname' => 'example.com',
                ],
            ],
        ];
    }
}
