<?php
/**
 * Created by PhpStorm.
 * User: duodraco
 * Date: 07/01/15
 * Time: 11:53
 */

namespace Duodraco\StarterToDo\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class Settings
{
    protected static $container;

    public static function setContainer(ContainerInterface $container)
    {
        return self::$container = $container;
    }

    public static function __callStatic($method, $parameters = [])
    {
        return call_user_func_array([self::$container, $method],$parameters);
    }
}
