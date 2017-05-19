<?php

namespace Baguette\Mastodon;

use Baguette\Mastodon\Entity\Entity;
use Symfony\Component\VarDumper\Caster\Caster;
use Symfony\Component\VarDumper\Caster\ClassStub;
use Symfony\Component\VarDumper\Cloner\Stub;

/**
 * Object caster for Symfony\VarDumper
 *
 * This is a class for debugging, and depends on Symfony\VarDumper.
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 Baguette HQ
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 * @see https://github.com/BaguettePHP/mastodon-api/wiki/ja-Debugging
 */
final class EntityCaster
{
    /** @var false */
    private $display_types = false;

    public function __construct(array $options = [])
    {
        if (isset($options['display_types'])) {
            $this->display_types = $options['display_types'];
        }
    }

    /**
     * @param Entity $c
     * @param array $_ ignore input array
     * @param Stub  $stub
     * @param bool  $isNested
     */
    public function __invoke(Entity $c, array $_, Stub $stub, $isNested)
    {
        $a = [];
        $ref = new \ReflectionClass($c);

        if ($this->display_types) {
            $ref_types = $ref->getProperty('property_types');
            $ref_types->setAccessible(true);
            $types = $ref_types->getValue();
            $ref_types->setAccessible(false);
            $a[Caster::PREFIX_PROTECTED.'property_types'] = $types;
        }

        $ref_properties = $ref->getProperty('properties');
        $ref_properties->setAccessible(true);
        $properties = $ref_properties->getValue($c);
        $ref_properties->setAccessible(false);

        foreach ($properties as $key => $prop) {
            $a[Caster::PREFIX_DYNAMIC.$key] = $prop;
        }

        return $a;
    }
}
