<?php

namespace RemoteDataStructures\Redis\Spl;

use RemoteDataStructures\Redis\RedisList;

/**
 * Remote stack (LIFO) backed by Redis.
 * 
 * Unlike SplStack doesnt fully implement \Iterator
 * 
 */
class RedisStack extends RedisList {
   
    /**
     * 
     * @param array $conf Configuration for Redis client
     */
    public function __construct($key = null, array $conf = null) {
        parent::__construct($key, $conf);
    }
    
    /**
     * @param mixed $value
     */
    public function push($value) {
        $cmd = $this->redis->createCommand('LPUSH');
        $cmd->setArguments(array($this->key, $value));
        $this->redis->executeCommand($cmd);
    }
    
    /**
     * @return mixed
     */
    public function pop() {
        $cmd = $this->redis->createCommand('LPOP');
        $cmd->setArguments(array($this->key));
        return $this->redis->executeCommand($cmd);
    }
    
}
