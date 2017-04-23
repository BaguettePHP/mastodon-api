<?php

namespace Baguette\Mastodon\Entity;

/**
 * Context
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#context
 * @property-read Status[] $ancestors   ancestors of the status in the conversation
 * @property-read Status[] $descendants descendants of the status in the conversation
 */
class Context extends Entity
{
    use \Teto\Object\TypedProperty;

    private static $property_types = [
        'ancestors'   => 'Status[]',
        'descendants' => 'Status[]',
    ];

    public function __construct(array $properties)
    {
        $this->setProperties($properties);
    }

    /**
     * Returns context data as array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'ancestors'   => toArrayValue($this->ancestors),
            'descendants' => toArrayValue($this->descendants),
        ];
    }
}
