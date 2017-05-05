<?php

namespace Baguette\Mastodon\Service;

/**
 * Mastodon Anthorization object
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @property-read string $access_token
 * @property-read string $token_type
 * @property-read Scope  $scope
 * @property-read \DateTimeImmutable $created_at
 */
class Authorization
{
    use \Teto\Object\PrivateGetter;

    /** @var string */
    private $access_token;
    /** @var string */
    private $token_type;
    /** @var Scope */
    private $scope;
    /** @var \DateTimeImmutable|null */
    private $created_at;

    /**
     * @param string   $access_token
     * @param string   $token_type
     * @param string[] $scope
     * @param int      $created_at
     */
    public function __construct(
        $access_token,
        $token_type = 'bearer',
        Scope $scope = null,
        $created_at = null
    ) {
        $this->access_token = $access_token;
        $this->token_type = $token_type;
        $this->scope      = $scope;
        if ($created_at !== null) {
            $this->created_at = (new \DateTimeImmutable)->setTimeStamp($created_at);
        }
    }

    /**
     * @param  object $obj
     * @return static
     */
    public static function fromObject($obj)
    {
        return new static(
            $obj->access_token,
            'bearer',
            \Baguette\Mastodon\scope($obj->scope),
            $obj->created_at
        );
    }
}
