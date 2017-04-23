<?php

namespace Baguette\Mastodon\Entity;

/**
 * Entity abstract class
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md
 */
abstract class Entity implements \Teto\Object\ToArrayInterface
{
    abstract public function __construct(array $properties);
}
