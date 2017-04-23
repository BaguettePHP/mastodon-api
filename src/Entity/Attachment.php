<?php

namespace Baguette\Mastodon\Entity;

/**
 * Attachment
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#attachment
 * @property-read int    $id   ID of the attachment
 * @property-read string $type One of: "image", "video", "gifv"
 * @property-read string $url  URL of the locally hosted version of the image
 * @property-read string $remote_url  For remote images, the remote URL of the original image
 * @property-read string $preview_url URL of the preview image
 * @property-read string $text_url    Shorter URL for the image, for insertion into text (only present on local images)
 */
class Attachment extends Entity
{
    use \Teto\Object\TypedProperty;

    private static $property_types = [
        'id'          => 'int',
        'type'        => 'enum',
        'url'         => 'string',
        'remote_url'  => 'string',
        'preview_url' => 'string',
        'text_url'    => 'string',
    ];

    private static $enum_values = [
        'type' => ['image', 'video', 'gifv'],
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
            'id'          => $this->id,
            'type'        => $this->type,
            'url'         => $this->url,
            'remote_url'  => $this->remote_url,
            'preview_url' => $this->preview_url,
            'text_url'    => $this->text_url,
        ];
    }
}
