<?php

namespace Baguette\Mastodon\Entity;

/**
 * Account
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#account
 * @property-read int    $id           The ID of the account
 * @property-read string $username     The username of the account
 * @property-read string $acct         Equals username for local users, includes @domain for remote ones
 * @property-read string $display_name The account's display name
 * @property-read bool   $locked       Boolean for when the account cannot be followed without waiting for approval first
 * @property-read \DateTimeImmutable $created_at The time the account was created
 * @property-read int    $followers_count The number of followers for the account
 * @property-read int    $following_count The number of accounts the given account is following
 * @property-read int    $statuses_count  The number of statuses the account has made
 * @property-read string $note Biography of user
 * @property-read string $url  URL of the user's profile page (can be remote)
 * @property-read string $avatar        URL to the avatar image
 * @property-read string $avatar_static URL to the avatar static image (gif)
 * @property-read string $header        URL to the header image
 * @property-read string $header_static URL to the header static image (gif)
 */
class Account extends Entity
{
    use \Teto\Object\TypedProperty;

    private static $property_types = [
        'id'              => 'int',
        'username'        => 'string',
        'acct'            => 'string',
        'display_name'    => 'string',
        'locked'          => 'bool',
        'created_at'      => \DateTimeImmutable::class,
        'followers_count' => 'int',
        'following_count' => 'int',
        'statuses_count'  => 'int',
        'note'            => 'string',
        'url'             => 'string',
        'avatar'          => 'string',
        'avatar_static'   => 'string',
        'header'          => 'string',
        'header_static'   => 'string',
    ];

    public function __construct(array $properties)
    {
        if (isset($properties['created_at'])) {
            $properties['created_at'] = map(\DateTimeImmutable::class, $properties['created_at']);
        }

        $this->setProperties($properties);
    }

    /**
     * Returns account data as array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'              => $this->id,
            'username'        => $this->username,
            'acct'            => $this->acct,
            'display_name'    => $this->display_name,
            'locked'          => $this->locked,
            'created_at'      => toArrayValue($this->created_at),
            'followers_count' => $this->followers_count,
            'following_count' => $this->following_count,
            'statuses_count'  => $this->statuses_count,
            'note'            => $this->note,
            'url'             => $this->url,
            'avatar'          => $this->avatar,
            'avatar_static'   => $this->avatar_static,
            'header'          => $this->header,
            'header_static'   => $this->header_static,
        ];
    }
}
