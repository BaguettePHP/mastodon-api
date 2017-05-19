<?php

namespace Baguette\Mastodon\Entity;

/**
 * Attachment
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md#notification
 * @property-read int    $id   notification ID
 * @property-read string $type One of: "mention", "reblog", "favourite", "follow"
 * @property-read \DateTimeImmutable $created_at time the notification was created
 * @property-read Account $account The Account sending the notification to the user
 * @property-read Status  $status  The Status associated with the notification, if applicable
 */
class Notification extends Entity
{
    use \Teto\Object\TypedProperty;

    private static $property_types = [
        'id'         => 'int',
        'type'       => 'enum',
        'created_at' => \DateTimeImmutable::class,
        'account'    => Account::class,
        'status'     => Status::class,
    ];

    private static $enum_values = [
        'type' => ['mention', 'reblog', 'favourite', 'follow'],
    ];

    public function __construct(array $properties)
    {
        $this->setProperties(mapValues($properties, [
            'created_at' =>\DateTimeImmutable::class,
            'account'    =>Account::class,
            'status'     =>Status::class,
        ]));
    }

    /**
     * Returns notification data as array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'         => $this->id,
            'type'       => $this->type,
            'created_at' => toArrayValue($this->created_at),
            'account'    => toArrayValue($this->account),
            'status'     => toArrayValue($this->status),
        ];
    }
}
