<?php

namespace RemoteDataStructures;

use Predis\Client;

/**
 * HashMap backed by Redis Hash.
 * 
 * @author Angel Garbayo
 */
abstract class RedisMap implements \Countable, \ArrayAccess {
    
    /** @var string */
    protected $key;
    
    /** @var Client */
    protected $redis;
    
    public function __construct(array $conf = null) {
        $this->redis = new Client($conf);
        $this->key = 'map';
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
