<?php

namespace RemoteDataStructures;

/**
 *
 */
class RedisQueue extends RedisData {
   
    /**
     * 
     * @param array $conf Configuration for Redis client
     */
    public function __construct($key = null, array $conf = null) {
        parent::__construct($key, $conf);
    }
    
    /**
     * Dequeues a node from the queue
     * @return mixed
     */
    public function dequeue() {
        $cmd = $this->redis->createCommand('rpop');
        $cmd->setArguments(array($this->key));
        $reply = $this->redis->executeCommand($cmd);
        return $reply;
    }
    
    /**
     * Adds an element to the queue
     * @param mixed $value
     */
    public function enqueue($value) {
        $cmd = $this->redis->createCommand('LPUSH');
        $cmd->setArguments(array($this->key, $value));
        $reply = $this->redis->executeCommand($cmd);
    }
    
}
