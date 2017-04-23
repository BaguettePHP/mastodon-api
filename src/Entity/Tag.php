<?php

namespace Baguette\Mastodon\Entity;

/**
 * Tag
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#tag
 * @property-read string $name The hashtag, not including the preceding #
 * @property-read string $url  The URL of the hashtag
 */
class Tag extends Entity
{
    use \Teto\Object\TypedProperty;

    private static $property_types = [
        'name' => 'string',
        'url'  => 'string',
    ];

    public function __construct(array $properties)
    {
        $this->setProperties($properties);
    }

    /**
     * Returns tag data as array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->name,
            'url'  => $this->url,
        ];
    }
}
