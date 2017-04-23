<?php

namespace Baguette\Mastodon;

/**
 * Mastodon Service
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
class Service
{
    /** @var string */
    private $instance;

    /**
     * @param string $instance
     */
    public function __construct($instance)
    {
        $this->instance = $instance;
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return parse_url($this->instance, PHP_URL_SCHEME) ?: 'https';
    }

    /**
     * @return string
     */
    public function getHostname()
    {
        return parse_url($this->instance, PHP_URL_HOST) ?: $this->instance;
    }
}
