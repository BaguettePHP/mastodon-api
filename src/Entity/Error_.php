<?php

namespace Baguette\Mastodon\Entity;

/**
 * Error
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#error
 * @property-read string $error A textual description of the error
 */
class Error_ extends Entity
{
    use \Teto\Object\TypedProperty;

    private static $property_types = [
        'error' => 'string',
    ];

    public function __construct(array $properties)
    {
        $this->setProperties($properties);
    }

    /**
     * Returns error data as array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'error' => $this->error,
        ];
    }
}
