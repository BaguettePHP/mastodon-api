<?php

namespace Baguette\Mastodon\Service;

/**
 * Scope
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
class Scope
{
    /** @var string[] */
    private $scopes;

    /**
     * @param string[] $scopes
     */
    public function __construct(array $scopes)
    {
        sort($scopes);
        $this->scopes = $scopes;
    }

    public function __toString()
    {
        return implode(' ', $this->scopes);
    }
}
