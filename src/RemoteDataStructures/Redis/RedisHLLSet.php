<?php

namespace RemoteDataStructures\Redis;

/**
 * Set implemented with Redis HyperLoglog.
 * 
 * Good explanation of HLL:
 * http://research.neustar.biz/2012/10/25/sketch-of-the-day-hyperloglog-cornerstone-of-a-big-data-infrastructure/
 * 
 * An example of use case:
 * http://qbolec-memdump.blogspot.co.uk/2014/01/counting-unique-items-in-sliding-window.html
 * 
 * @author Angel Garbayo
 */
class RedisHLLSet extends RedisData implements \Countable, \RemoteDataStructures\Set {
    use RedisDataFormat;
    
    
    public function count() {
        return $this->redis->pfcount($this->key);
    }
    
    public function add($member) {
        $this->redis->pfadd($this->key, $this->toRedisFormat($member));
    }
    
    public function pop() {
        throw new \BadMethodCallException("pop is not implemented on RedisHLL");
    }
    
    /**
     * Remove element
     */
    public function rem($member) {
        throw new \BadMethodCallException("rem is not implemented on RedisHLL");
    }
    
    /**
     * @param mixed $member
     * @return bool 
     */
    public function isMember($member) {
        return 0 < $this->redis->pfcount($this->key, $this->toRedisFormat($member));
    }
    
    public function delete() {
        $this->redis->del($this->key);
    }
    
}
