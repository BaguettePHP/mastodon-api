<?php

/**
 * Mastodon API functions
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */

namespace Baguette\Mastodon;

use Baguette\Mastodon\Grant;
use Baguette\Mastodon\Service;
use Baguette\Mastodon\Service\Scope;

/**
 * @param  string   $instance
 * @param  string   $client_id
 * @param  string   $client_secret
 * @param  array    $options
 * @return Mastodon
 */
function session($instance, $client_id, $client_secret, array $options)
{
    $scope = null;
    $grant = null;
    $authorization = null;

    $client = new Client($instance);

    if (isset($options['scope'])) {
        $scope = scope($options['scope']);
    }

    if (isset($options['credential'])) {
        trigger_error('`credential` is obsolete option.  Use `grant` instead.', E_USER_DEPRECATED);
        $grant = credential($options['credential']);
    }

    if (isset($options['grant'])) {
        $grant = grant($options['grant']);
    }

    if (isset($options['authorization'])) {
        $authorization = authorization($options['authorization']);
    }

    //throw new \LogicException('"scope" is not set.');

    $auth_factory = new Service\AuthFactory($client, $client_id, $client_secret);
    if ($grant !== null) {
        $auth_factory->setGrant($grant);
    }

    $session = new Service\SessionStorage($auth_factory, $scope);
    if ($authorization !== null) {
        $session->setAuthorization($authorization);
    }

    return new Mastodon($client, $session);
}

/**
 * @param  Scope|string|string[]
 * @return Scope
 */
function scope($scope)
{
    if (is_array($scope)) {
        return new Scope($scope);
    } elseif ($scope instanceof Scope) {
        return $scope;
    }

    return new Scope(explode(' ', $scope));
}

/**
 * @param  string $toot_string
 * @param  array  $options
 * @return Service\Toot
 */
function toot($toot_string, array $options = [])
{
    return new Service\Toot($toot_string, $options);
}

/**
 * @deprecated
 */
function credential(array $data)
{
    trigger_error('credential() is obsolete function.  Use grant() instead.', E_USER_DEPRECATED);
    return grant($data);
}

/**
 * @return Grant\Grant
 */
function grant(array $data)
{
    if (isset($data['username'], $data['password'])) {
        return new Grant\PasswordCredential($data['username'], $data['password']);
    }
}

/**
 * @return Service\Authorization
 */
function authorization(array $data)
{
    return Service\Authorization::fromObject((object)$data);
}

/**
 * @return \GuzzleHttp\ClientInterface
 */
function http(\GuzzleHttp\ClientInterface $client = null)
{
    /** @var \GuzzleHttp\ClientInterface */
    static $cached_client;

    if ($client !== null) {
        $cached_client = $client;
    } elseif ($cached_client === null) {
        $cached_client = new \GuzzleHttp\Client;
    }

    return $cached_client;
}
