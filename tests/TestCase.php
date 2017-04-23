<?php

namespace Baguette\Mastodon;

/**
 * BaseClass for TestCase
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @param  string|array $class_method "Klass::method_name"
     * @return \Closure
     */
    public static function getPrivateMethodAsPublic($class_method)
    {
        if (is_string($class_method)) {
            list($class, $method) = explode('::', $class_method, 2);
        } elseif (is_array($class_method) && count($class_method) === 2) {
            list($class, $method) = $class_method;
        } else {
            throw new \LogicException;
        }

        $ref = new \ReflectionMethod($class, $method);
        $ref->setAccessible(true);
        $obj = (gettype($class) === 'object') ? $class : null;

        return function () use ($class, $ref, $obj) {
            $args = func_get_args();
            return $ref->invokeArgs($obj, $args);
        };
    }
}
