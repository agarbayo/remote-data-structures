<?php

namespace RemoteDataStructures;

/**
 * Remote min heap backed by a Redis SortedSet.
 * 
 * Unlike SplHeap doesnt fully implement \Iterator
 */
class RedisMinHeap extends RedisHeap {
    
    /**
     * 
     * @param array $conf Configuration for Redis client
     */
    public function __construct($key = null, array $conf = null) {
        parent::__construct($key, $conf);
    }
    
    /**
     * Get score to order elements. By default ordered from lowest to highest .
     * 
     * @param mixed $value
     * @return int
     */
    public function getScore($value) {
        return $value;
    }
       
}
