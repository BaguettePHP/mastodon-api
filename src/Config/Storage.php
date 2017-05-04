<?php

namespace Baguette\Mastodon\Config;

/**
 * Mastodon config storage interface
 *
 * @see https://github.com/vlucas/phpdotenv
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
interface Storage
{
    /** @return void */
    public function save();
}
