<?php

namespace RemoteDataStructures;

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
    public function __construct(array $conf = null) {
        parent::__construct($conf);
        $this->key  = 'stack';
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
