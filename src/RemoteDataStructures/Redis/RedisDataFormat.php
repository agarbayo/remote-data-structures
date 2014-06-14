<?php

namespace RemoteDataStructures\Redis;

/**
 * 
 */
trait RedisDataFormat {
    
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

