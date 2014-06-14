<?php

namespace RemoteDataStructures\Redis;

/**
 * Set implemented with Redis
 * 
 * @author Angel Garbayo
 */
class RedisSet extends RedisData implements \Countable, \RemoteDataStructures\Set {
    
    
    public function count() {
        return $this->redis->scard($this->key);
    }
    
    public function add($member) {
        $this->redis->sadd($this->key, $this->toRedisFormat($member));
    }
    
    public function pop() {
        return $this->fromRedisFormat($this->redis->spop($this->key));
    }
    
    /**
     * Remove element
     */
    public function rem($member) {
        $this->redis->srem($this->key, $this->toRedisFormat($member));
    }
    
    /**
     * @param mixed $member
     * @return bool 
     */
    public function isMember($member) {
        return $this->redis->sismember($this->key, $this->toRedisFormat($member));
    }
    
    public function delete() {
        $this->redis->del($this->key);
    }
    
    /**
     * Makes sure the member can be sent to Redis. 
     * 
     * @param mixed $member
     * @return mixed 
     */
    private function toRedisFormat($member) {
        return is_object($member)?serialize($member):$member;
    }
    
    private function fromRedisFormat($data) {
        $unserialized = @unserialize($data);
        return ($unserialized==false)?$data:$unserialized;
    }
    
}
