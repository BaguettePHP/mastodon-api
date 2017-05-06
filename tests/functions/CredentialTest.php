<?php

namespace Baguette\Mastodon\functions;

use Baguette\Mastodon\Grant;
use Baguette\Mastodon\Grant\PasswordCredential;

/**
 * credential function
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
class CredentialTest extends \Baguette\Mastodon\TestCase
{
    /**
     * @dataProvider dataProviderFor_test
     */
    public function test(array $input, $expected_concrete)
    {
        $actual = \Baguette\Mastodon\grant($input);

        $this->assertInstanceOf(Grant\Grant::class, $actual);
        $this->assertInstanceOf($expected_concrete, $actual);
    }

    public function dataProviderFor_test()
    {
        return [
            [
                'input' => [
                    'username' => 'aaa',
                    'password' => 'bbb',
                ],
                'concrete' => PasswordCredential::class,
            ],
        ];
    }
}
