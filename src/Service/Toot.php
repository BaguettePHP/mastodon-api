<?php

namespace Baguette\Mastodon\Service;

use Respect\Validation\Validator as v;

/**
 * Toot
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @property-read string     $toot_string
 * @property-read int[]      $media_ids
 * @property-read int|null   $in_reply_to_id
 * @property-read string     $visibility
 * @property-read bool|null  $sensitive
 * @property-read string|null $spoiler_text
 */
class Toot
{
    use \Teto\Object\PrivateGetter;
    use \Teto\Object\ReadOnly;

    const VISIBILITY_DIRECT   = 'direct';
    const VISIBILITY_PRIVATE  = 'private';
    const VISIBILITY_UNLISTED = 'unlisted';
    const VISIBILITY_PUBLIC   = 'public';

    private static $VISIBILITIES = [
        Toot::VISIBILITY_PUBLIC,
        Toot::VISIBILITY_UNLISTED,
        Toot::VISIBILITY_PRIVATE,
        Toot::VISIBILITY_DIRECT,
    ];

    /** @var string */
    private $toot_string;
    /** @var int[] */
    private $media_ids = [];
    /** @var int|null */
    private $in_reply_to_id;
    /** @var string|null */
    private $visibility;
    /** @var bool|null */
    private $sensitive;
    /** @var string|null */
    private $spoiler_text;

    /**
     * @param string[] $scopes
     */
    public function __construct($toot_string, array $options)
    {
        v::stringType()->assert($toot_string);
        $this->toot_string = $toot_string;

        if (isset($options['media_ids'])) {
            $ids = [];
            foreach ($options['media_ids'] as $id) {
                v::intType()->assert($id);
                $ids[] = $id;
            }
            $this->media_ids = $ids;
        }

        if (isset($options['in_reply_to_id'])) {
            v::intType()->assert($options['in_reply_to_id']);
            $this->in_reply_to_id = $options['in_reply_to_id'];
        }

        if (isset($options['visibility'])) {
            v::in(Toot::$VISIBILITIES)->assert($options['visibility']);
            $this->visibility = $options['visibility'];
        }

        if (isset($options['senstitive'])) {
            v::bool()->assert($options['senstitive']);
            $this->senstitive = $options['senstitive'];
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if ($this->visibility === Toot::VISIBILITY_PUBLIC) {
            return $this->toot_string;
        }

        return "[{$this->visibility}]";
    }
}
