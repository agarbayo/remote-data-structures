<?php

namespace RemoteDataStructures;

/**
 *
 * @author Angel Garbayo
 */
class RedisConfiguration {
    
    /** @var array */
    private static $params;
    
    public static function setParameters($params, $key = 'default') {
        self::$params[$key] = $params;
    }
    
    public static function getParameters($key = 'default') {
        return isset(self::$params[$key])?self::$params[$key]:null;
    }
}
