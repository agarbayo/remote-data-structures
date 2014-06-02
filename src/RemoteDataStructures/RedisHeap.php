<?php

namespace RemoteDataStructures;

use Predis\Client;

/**
 * Remote heap backed by a Redis SortedSet.
 * 
 * Unlike SplHeap doesnt fully implement \Iterator
 */
abstract class RedisHeap implements \Countable {
    
    /** @var string */
    protected $key;
    
    /** @var Client */
    protected $redis;
    
    /** @var string Decides order in which elements by score are retrieved */
    protected $rangeCmd = 'ZRANGE';
   
    /**
     * 
     * @param array $conf Configuration for Redis client
     */
    public function __construct(array $conf = null) {
        $this->redis = new Client($conf);
        $this->key  = 'heap';
    }
    
    public function count() {
        $cmd = $this->redis->createCommand('ZCARD');
        $cmd->setArguments(array($this->key));
        return $this->redis->executeCommand($cmd);
    }
    
    public function isEmpty() {
        return $this->count() == 0;
    }
    
    /**
     * Extract is performed with two operations ZRANGE and ZREM it might return 
     * twice the same value in high concurrency.
     * 
     * @return mixed
     */
    public function extract() {
        $cmd = $this->redis->createCommand($this->rangeCmd);
        $cmd->setArguments(array($this->key, 0, 0));
        $valueArray = $this->redis->executeCommand($cmd);
        $value = array_pop($valueArray);
        $this->rem($value);
        return $value;
    }
    
    protected function rem($value) {
        $cmdRem = $this->redis->createCommand('ZREM');
        $cmdRem->setArguments(array($this->key, $value));
        $this->redis->executeCommand($cmdRem);
    }
    
    /**
     * 
     * @param mixed $value
     */
    public function insert($value) {
        $cmd = $this->redis->createCommand('ZADD');
        $cmd->setArguments(array($this->key, $this->getScore($value), $value));
        $this->redis->executeCommand($cmd);
    }
    
    /**
     * Implement getScore instead of compare.
     * @param mixed $value1
     * @param mixedd $value2
     */
    private function compare($value1, $value2) {
    }
    
    /**
     * Get score to order elements. By default ordered from lowest to highest .
     * 
     * @param mixed $value
     * @return int
     */
    abstract function getScore($value);
       
}
