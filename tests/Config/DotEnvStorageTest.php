<?php

namespace Baguette\Mastodon\Config;

/**
 * Toot
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
class DotEnvStorageTest extends \Baguette\Mastodon\TestCase
{
    /**
     * @dataProvider dataProviderFor_test
     */
    public function test($file, $options, array $expected)
    {
        $actual = new DotEnvStorage($file, $options);

        $this->assertEquals($expected['getValues'], $actual->getValues());
        $this->assertEquals($expected['getAppName'], $actual->getAppName());
        $this->assertEquals($expected['getClientIdAndSecret'], $actual->getClientIdAndSecret());
        $this->assertEquals($expected['getUsernameAndPassword'], $actual->getUsernameAndPassword());
    }

    public function dataProviderFor_test()
    {
        return [
            [
                'file' => $this->mkstream(''),
                'options' => [],
                'expected' => [
                    'getValues' => [],
                    'getAppName' => [
                        'app_name' => null,
                    ],
                    'getClientIdAndSecret' => [
                        'client_id' => null,
                        'client_secret' => null,
                    ],
                    'getUsernameAndPassword' => [
                        'username' => null,
                        'password' => null,
                    ],
                ],
            ],
            [
                'file' => $this->mkstream('
Foo=Bar
APP_NAME="Awesome Client"
USERNAME=tarosa
PASSWORD="passwd"
'),
                'options' => [],
                'expected' => [
                    'getValues' => [
                        'Foo' => 'Bar',
                        'APP_NAME' => 'Awesome Client',
                        'USERNAME' => 'tarosa',
                        'PASSWORD' => 'passwd',
                    ],
                    'getAppName' => [
                        'app_name' => 'Awesome Client',
                    ],
                    'getClientIdAndSecret' => [
                        'client_id' => null,
                        'client_secret' => null,
                    ],
                    'getUsernameAndPassword' => [
                        'username' => 'tarosa',
                        'password' => 'passwd',
                    ],
                ],
            ],
            [
                'file' => __DIR__ . DIRECTORY_SEPARATOR . 'test1.env',
                'options' => [],
                'expected' => [
                    'getValues' => [
                        'APP_NAME'      => 'Awesome Client',
                        'CLIENT_ID'     => 'qawsedrftgyhujikolp',
                        'CLIENT_SECRET' => 'zasxcdgbjmkkeqoae',
                        'USERNAME'      => 'jirosa',
                        'PASSWORD'      => 'i_am_jiro',
                    ],
                    'getAppName' => [
                        'app_name' => 'Awesome Client',
                    ],
                    'getClientIdAndSecret' => [
                        'client_id' => 'qawsedrftgyhujikolp',
                        'client_secret' => 'zasxcdgbjmkkeqoae',
                    ],
                    'getUsernameAndPassword' => [
                        'username' => 'jirosa',
                        'password' => 'i_am_jiro',
                    ],
                ],
            ],
            [
                'file' => __DIR__ . DIRECTORY_SEPARATOR . 'test0.env',
                'options' => [],
                'expected' => [
                    'getValues' => [],
                    'getAppName' => [
                        'app_name' => null,
                    ],
                    'getClientIdAndSecret' => [
                        'client_id' => null,
                        'client_secret' => null,
                    ],
                    'getUsernameAndPassword' => [
                        'username' => null,
                        'password' => null,
                    ],
                ],
            ],
            [
                'file' => $this->mkstream('
Foo="Fizz\"Buzz"
'),
                'options' => [],
                'expected' => [
                    'getValues' => [
                        'Foo' => 'Fizz"Buzz',
                    ],
                    'getAppName' => [
                        'app_name' => null,
                    ],
                    'getClientIdAndSecret' => [
                        'client_id' => null,
                        'client_secret' => null,
                    ],
                    'getUsernameAndPassword' => [
                        'username' => null,
                        'password' => null,
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderFor_test_set
     */
    public function test_set($file, array $set_values, $expected)
    {
        $store = new DotEnvStorage($file, ['read_only' => false]);

        foreach ($set_values as $method => $args) {
            call_user_func_array([$store, $method], $args);
        }

        $store->save();

        rewind($file);
        $actual = stream_get_contents($file);

        $this->assertEquals($expected, $actual);
    }

    public function dataProviderFor_test_set()
    {
        return [
            [
                'file' => $this->mkstream(''),
                'set_values' => [],
                'expected' => '
',
            ],
            [
                'file' => $this->mkstream(''),
                'set_values' => [
                    'setAppName' => ['HogeHoge'],
                ],
                'expected' => '
APP_NAME="HogeHoge"
',
            ],
            [
                'file' => $this->mkstream('
APP_NAME=FugaFuga'),
                'set_values' => [
                    'setAppName' => ['HogeHoge'],
                ],
                'expected' => '
APP_NAME="HogeHoge"
',
            ],
            [
                'file' => $this->mkstream('# Comment
APP_NAME=FugaFuga'),
                'set_values' => [
                    'setAppName' => ['HogeHoge'],
                ],
                'expected' => '# Comment
APP_NAME="HogeHoge"
',
            ],
            [
                'file' => $this->mkstream('# Comment


APP_NAME=FugaFuga'),
                'set_values' => [
                    'setAppName' => ['HogeHoge'],
                ],
                'expected' => '# Comment


APP_NAME="HogeHoge"
',
            ],
            [
                'file' => $this->mkstream(''),
                'set_values' => [
                    'setAppName' => ['HogeHoge'],
                    'setClientIdAndSecret' => ['xxxxx', 'yyyyy'],
                ],
                'expected' => '
APP_NAME="HogeHoge"
CLIENT_ID="xxxxx"
CLIENT_SECRET="yyyyy"
',
            ],
            [
                'file' => $this->mkstream(''),
                'set_values' => [
                    'setClientIdAndSecret' => ['xxxxx', 'yyyyy'],
                    'setAppName' => ['HogeHoge'],
                ],
                'expected' => '
CLIENT_ID="xxxxx"
CLIENT_SECRET="yyyyy"
APP_NAME="HogeHoge"
',
            ],
            [
                'file' => $this->mkstream(''),
                'set_values' => [
                    'setAppName' => ['HogeHoge'],
                    'setClientIdAndSecret' => ['xxxxx', 'yyyyy'],
                    'setUsernameAndPassword' => ['saburo', 'joepass'],
                ],
                'expected' => '
APP_NAME="HogeHoge"
CLIENT_ID="xxxxx"
CLIENT_SECRET="yyyyy"
USERNAME="saburo"
PASSWORD="joepass"
',
            ],
        ];
    }
}
