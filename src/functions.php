<?php

/**
 * Mastodon API functions
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */

namespace Baguette\Mastodon;

/**
 * @param  string
 * @return \Baguette\Mastodon\Service\Scope
 */
function scope($scope)
{
    return new \Baguette\Mastodon\Service\Scope(explode(' ', $scope));
}
