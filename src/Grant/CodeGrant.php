<?php

namespace Baguette\Mastodon\Grant;

use Baguette\Mastodon;
use Baguette\Mastodon\Service\AuthFactory;
use Baguette\Mastodon\Service\Scope;
use GuzzleHttp\ClientInterface as Client;
use Respect\Validation\Validator as v;

/**
 * Mastodon Authorization Code grant
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://tools.ietf.org/html/draft-ietf-oauth-v2-22#section-4.1
 */
class CodeGrant extends Grant
{
    /** @var string */
    private $code;
    /** @var string */
    private $redirect_uri;

    /**
     * @param string $code
     * @param string $redirect_uri
     */
    public function __construct($code, $redirect_uri)
    {
        $this->code = $code;
        $this->redirect_uri = $redirect_uri;
    }

    /**
     * @param  Mastodon\Client $client
     * @param  AuthFactory $auth
     * @param  Scope  $scope
     * @param  string $callback_uri
     * @param  string $state
     * @return string
     */
    public static function getRedirectUrl(Mastodon\Client $client, Mastodon\Service\AuthFactory $auth, Scope $scope, $callback_uri, $state = null)
    {
        $query = [
            'client_id' => $auth->client_id,
            'response_type' => 'code',
            'redirect_uri' => $callback_uri,
            'scopes' => (string)$scope,
        ];

        if ($state !== null) {
            v::stringType()->length(1, null)->assert($state);
            $query['state'] = $state;
        }

        return sprintf('%s://%s/oauth/authorize?%s', $client->getScheme(), $client->getHostname(), http_build_query($query));
    }

    /**
     * @param  Client      $http
     * @param  AuthFactory $factory
     * @param  Scope       $scope
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function auth(Client $http, AuthFactory $factory, Scope $scope = null)
    {
        return $http->request('POST', static::getPathToOAuthToken($factory->client), [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code'  => $this->code,
                'redirect_uri' => $this->redirect_uri,
            ] + static::getFormParamsWithSecret($factory),
        ]);
    }
}
