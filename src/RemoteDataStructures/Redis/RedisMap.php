<?php

namespace RemoteDataStructures\Redis;

/**
 * HashMap backed by Redis Hash.
 * 
 * @author Angel Garbayo
 */
abstract class RedisMap extends RedisData implements \Countable, \ArrayAccess {
    
    public function __construct($key = null, array $conf = null) {
        parent::__construct($key, $conf);
    }
    
    public function count() {
        $cmd = $this->redis->createCommand('HLEN');
        $cmd->setArguments(array($this->key));
        return $this->redis->executeCommand($cmd);
    }
    
    
    public function offsetExists($key) { 
        $cmd = $this->redis->createCommand('HEXISTS');
        $cmd->setArguments(array($this->key, $key));
        return $this->redis->executeCommand($cmd);
    }
    
    public function offsetGet($key) { 
        $cmd = $this->redis->createCommand('HGET');
        $cmd->setArguments(array($this->key, $key));
        return $this->redis->executeCommand($cmd);
    }
    
    public function offsetSet($key, $newval) { 
        $cmd = $this->redis->createCommand('HSET');
        $cmd->setArguments(array($this->key, $key, $newval));
        $this->redis->executeCommand($cmd);
    }
    
    public function offsetUnset($key) { 
        $this->bulkUnset([$key]);
    }
    
    public function bulkUnset(array $keys) {
        $cmd = $this->redis->createCommand('HDEL');
        $args = array_merge($this->key, $keys);
        $cmd->setArguments($args);
        $this->redis->executeCommand($cmd);
    }
    
    public function keys() {
        $cmd = $this->redis->createCommand('HKEYS');
        $cmd->setArguments(array($this->key, $key));
        return $this->redis->executeCommand($cmd);
    }
}
