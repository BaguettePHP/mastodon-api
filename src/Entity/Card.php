<?php

namespace Baguette\Mastodon\Entity;

/**
 * Card
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#card
 * @property-read string $url   The url associated with the card
 * @property-read string $title The title of the card
 * @property-read string $description The card description
 */
class Card extends Entity
{
    use \Teto\Object\TypedProperty;

    private static $property_types = [
        'url'   => 'string',
        'title' => 'string',
        'description' => 'string',
    ];

    public function __construct(array $properties)
    {
        $this->setProperties($properties);
    }

    /**
     * Returns attachment data as array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'url'   => $this->url,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
