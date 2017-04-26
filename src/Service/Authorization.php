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
    /** @var \DateTimeImmutable */
    private $created_at;

    /**
     * @param string   $access_token
     * @param string   $token_type
     * @param string[] $scope
     * @param int      $created_at
     */
    public function __construct($access_token, $token_type, Scope $scope, $created_at)
    {
        $this->access_token = $access_token;
        $this->token_type = $token_type;
        $this->scope      = $scope;
        $this->created_at = (new \DateTimeImmutable)->setTimeStamp($created_at);
    }

    /**
     * @param  object $obj
     * @return static
     */
    public static function fromObject($obj)
    {
        return new static(
            $obj->access_token,
            $obj->token_type,
            \Baguette\Mastodon\scope($obj->scope),
            $obj->created_at
        );
    }
}
