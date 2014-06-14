<?php

namespace RemoteDataStructures\Redis;

/**
 * Counter backed by Redis incr/decr
 * 
 * @author Angel Garbayo
 */
class RedisCounter extends RedisData implements \RemoteDataStructures\Counter {
    
    public function delete() {
        $this->redis->del($this->key);
    }

    public function get() {
        return $this->redis->get($this->key);
    }

    public function incr($by = 1) {
        $cmd = ($by>0)?'incrby':'decrby';
        return $this->redis->$cmd($this->key, abs($by));
    }

}
