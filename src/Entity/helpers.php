<?php

/**
 * Helper functions for Mastodon API Entity
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
namespace Baguette\Mastodon\Entity
{
    /**
     * @param  mixed $value
     * @return string|array
     */
    function toArrayValue($value)
    {
        if ($value instanceof \DateTimeInterface) {
            return $value->format(\DateTime::W3C);
        }

        return \Teto\Object\Helper::toArray($value);
    }
}
