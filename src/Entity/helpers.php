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
    const DATETIME_FORMAT = 'Y-m-d\TH:i:s.uO';

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

    /**
     * Mapping values to class
     *
     * @param  string|string[] $class
     * @param  mixed           $values
     * @return Entity|Entity[]|\DateTimeImmutable
     */
    function map($class, $values)
    {
        if (!is_array($class)) {
            return ($values instanceof $class) ? $values : new $class($values);
        }

        $class = array_pop($class);
        $retval = [];
        foreach ($values as $obj) {
            $retval[] = ($obj instanceof $class) ? $obj : new $class($obj);
        }

        return $retval;
    }
}
