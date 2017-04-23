<?php

namespace Baguette\Mastodon\Entity;

/**
 * Instance
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#instance
 * @property-read string $uri         URI of the current instance
 * @property-read string $title       The instance's title
 * @property-read string $description A description for the instance
 * @property-read string $email       An email address which can be used to contact the instance administrator
 */
class Instance extends Entity
{
    use \Teto\Object\TypedProperty;

    private static $property_types = [
        'uri'         => 'string',
        'title'       => 'string',
        'description' => 'string',
        'email'       => 'string',
    ];

    public function __construct(array $properties)
    {
        $this->setProperties($properties);
    }

    /**
     * Returns instance data as array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'uri'         => $this->uri,
            'title'       => $this->title,
            'description' => $this->description,
            'email'       => $this->email,
        ];
    }
}
