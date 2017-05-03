<?php

namespace Baguette\Mastodon;

use Baguette\Mastodon;
use Baguette\Mastodon\Client as MastodonClient;
use Baguette\Mastodon\Service\AuthFactory;
use Baguette\Mastodon\Service\Scope;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\StreamInterface;

/**
 * BaseClass for TestCase
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
abstract class RequesterTestCase extends TestCase
{
    const CLIENT_ID     = 'xxxxxxxxxxxxxxxxxx';
    const CLIENT_SECRET = 'yyyyyyyyyyyyyyyyyy';
    const HOSTNAME = 'mstdn.example.com';
    const USERNAME = 'i_am_joe';
    const PASSWORD = 'itsapasswd';

    /** @var \Baguette\Mastodon\Client */
    protected $client;
    /** @var \Baguette\Mastodon\Service\AuthFactory */
    protected $auth_factory;
    /** @var \GuzzleHttp\Handler\MockHandler */
    private $guzzle_mock_handler;

    public function setUp()
    {
        parent::setUp();

        $this->client = new MastodonClient(static::HOSTNAME);
        $this->auth_factory = new AuthFactory(
            $this->client, static::CLIENT_ID, static::CLIENT_SECRET
        );
        $this->auth_factory->setCredential(Mastodon\credential([
            'username' => static::USERNAME,
            'password' => static::PASSWORD,
        ]));
    }


    /**
     * @param int                                  $status  Status code
     * @param array                                $headers Response headers
     * @param string|null|resource|StreamInterface $body    Response body
     * @param string                               $version Protocol version
     * @param string|null                          $reason  Reason phrase (when empty a default will be used based on the status code)
     */
    protected function addHttpMockResponse(
        $status = 200,
        array $headers = [],
        $body = null,
        $version = '1.1',
        $reason = null
    ) {
        $this->initGuzzleHandler();

        $response = new Response($status, $headers, $body, $version, $reason);
        $this->guzzle_mock_handler->append($response);
    }

    /**
     * @return Service\SessionStorage
     */
    protected function getSession(Scope $scope = null)
    {
        $scope = $scope ?: scope('read');
        $session = new Service\SessionStorage($this->auth_factory, $scope);
        $session->setAuthorization(new Service\Authorization(
            'zzzzzzzzzzzzzzzzzz', 'bearer', $scope, time()
        ));

        return $session;
    }

    /**
     * @return void
     */
    private function initGuzzleHandler()
    {
        if ($this->guzzle_mock_handler !== null) {
            return;
        }

        $this->guzzle_mock_handler = new MockHandler;

        $this->client->setAPIHttpClient(new \GuzzleHttp\Client([
            'handler' => $this->guzzle_mock_handler,
        ]));
    }
}
