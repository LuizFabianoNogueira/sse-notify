<?php

namespace LuizFabianoNogueira\SseNotify\Enums;

use ReflectionException;

abstract class SseEnum
{
    /**
     * @param $class
     * @return array
     * @throws ReflectionException
     */
    public static function getConstants($class): array
    {
        return (new \ReflectionClass($class))->getConstants();
    }
}
