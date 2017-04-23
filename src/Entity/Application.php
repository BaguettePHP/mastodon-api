<?php

namespace Baguette\Mastodon\Entity;

/**
 * Application
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#application
 * @property-read int    $name    Name of the app
 * @property-read string $website Homepage URL of the app
 */
class Application extends Entity
{
    use \Teto\Object\TypedProperty;

    private static $property_types = [
        'name'    => 'string',
        'website' => 'string',
    ];

    public function __construct(array $properties)
    {
        $this->setProperties($properties);
    }

    /**
     * Returns application data as array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'name'    => $this->name,
            'website' => $this->website,
        ];
    }
}
