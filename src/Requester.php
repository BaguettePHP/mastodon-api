<?php

namespace Baguette\Mastodon;

use Baguette\Mastodon\Client;
use Baguette\Mastodon\Entity;
use Baguette\Mastodon\Service\SessionStorage;
use Baguette\Mastodon\Service\Toot;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator as v;

/**
 * Mastodon Anthorization object factory
 *
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
class Requester
{
    /**
     * Fetching an account
     *
     * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#fetching-an-account
     * @param  Client         $client
     * @param  SessionStorage $session
     * @param  int            $id
     * @return Entity\Account
     */
    public static function getAccount(Client $client, SessionStorage $session, $id)
    {
        v::intVal()->min(0)->assert($id);

        return static::map(
            Entity\Account::class,
            $client->requestAPI('GET', sprintf('/api/v1/accounts/%d', $id), [], $session)
        );
    }

    /**
     * Getting the current user
     *
     * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#getting-the-current-user
     * @param  Client         $client
     * @param  SessionStorage $session
     * @return Entity\Account
     */
    public static function getAccountCurrentUser(Client $client, SessionStorage $session)
    {
        return static::map(
            Entity\Account::class,
            $client->requestAPI('GET', '/api/v1/accounts/verify_credentials', [], $session)
        );
    }

    /**
     * Updating the current user
     *
     * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#updating-the-current-user
     * @param  Client         $client
     * @param  SessionStorage $session
     * @param  array          $update_data
     * @return Entity\Account
     */
    public static function updateAccount(Client $client, SessionStorage $session, $update_data)
    {
        $form_params = [];

        if (isset($update_data['display_name'])) {
            v::stringType()->assert($update_data['display_name']);
            $form_params['display_name'] = (string)$update_data['display_name'];
        }

        if (isset($update_data['note'])) {
            v::stringType()->assert($update_data['note']);
            $form_params['note'] = (string)$update_data['note'];
        }

        return static::map(
            Entity\Account::class,
            $client->requestAPI('PATCH', '/api/v1/accounts/update_credentials', [
                'form_params' => $form_params
            ], $session)
        );
    }

    /**
     * Posting a new status
     *
     * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#posting-a-new-status
     * @param Toot $toot
     * @return Entity\Account
     */
    public static function postStatus(Client $client, SessionStorage $session, Toot $toot)
    {
        $form_params = [
            'status' => $toot->toot_string,
        ];

        if ($toot->sensitive) {
            $form_params['sensitive'] = 'true';
        }

        if ($toot->in_reply_to_id) {
            $form_params['in_reply_to_id'] = $toot->in_reply_to_id;
        }

        if (count($toot->media_ids) > 0) {
            $form_params['media_ids'] = $toot->media_ids;
        }

        if ($toot->visibility === null) {
            $form_params['visibility'] = $toot->visibility;
        }

        return static::map(
            Entity\Status::class,
            $client->requestAPI('POST', '/api/v1/statuses', [
                'form_params' => $form_params
            ], $session)
        );
    }

    /**
     * @param  string|string[]   $class
     * @param  ResponseInterface $response
     * @return Entity\Entity|Entity\Entity[]
     */
    private static function map($class, ResponseInterface $response)
    {
        return Entity\map(
            $class,
            \GuzzleHttp\json_decode($response->getBody(), true)
        );
    }
}
