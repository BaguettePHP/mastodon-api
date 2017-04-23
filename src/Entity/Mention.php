<?php

namespace Baguette\Mastodon\Entity;

/**
 * Mention
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#mention
 * @property-read string $url      URL of user's profile (can be remote)
 * @property-read string $username The username of the account
 * @property-read string $acct     Equals username for local users, includes @domain for remote ones
 * @property-read int    $id       Account ID
 */
class Mention extends Entity
{
    use \Teto\Object\TypedProperty;

    private static $property_types = [
        'url'      => 'string',
        'username' => 'string',
        'acct'     => 'string',
        'id'       => 'int',
    ];

    public function __construct(array $properties)
    {
        $this->setProperties($properties);
    }

    /**
     * Returns mention data as array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'url'      => $this->url,
            'username' => $this->username,
            'acct'     => $this->acct,
            'id'       => $this->id,
        ];
    }
}
