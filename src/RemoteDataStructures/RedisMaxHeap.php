<?php

namespace RemoteDataStructures;

/**
 * Remote max heap backed by a Redis SortedSet.
 * 
 * Unlike SplHeap doesnt fully implement \Iterator
 */
class RedisMaxHeap extends RedisHeap {
    
    /**
     * 
     * @param array $conf Configuration for Redis client
     */
    public function __construct(array $conf = null) {
        parent::__construct($conf);
        $this->rangeCmd = 'ZREVRANGE';
        $this->key  = 'maxheap';
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
