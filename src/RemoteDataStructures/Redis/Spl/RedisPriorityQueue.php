<?php

namespace RemoteDataStructures\Redis\Spl;

/**
 * Remote max heap backed by a Redis SortedSet.
 * 
 * Unlike SplPriorityQueue doesnt fully implement \Iterator
 */
class RedisPriorityQueue extends RedisMaxHeap {

    /** @var int */
    private $flags = \SplPriorityQueue::EXTR_DATA;
    
    /**
     * 
     * @param array $conf Configuration for Redis client
     */
    public function __construct($key = null, array $conf = null) {
        parent::__construct($key, $conf);
    }
    
     public function extract() {
        $cmd = $this->redis->createCommand($this->rangeCmd);
        $params = [$this->key, 0, 0];
        if ($this->flags !=\SplPriorityQueue::EXTR_DATA) {
            $params[]='WITHSCORES';
        }
        $cmd->setArguments($params);
        
        $valueArray = $this->redis->executeCommand($cmd);
        $valueScoreArray = array_pop($valueArray);
        
        if ($this->flags !=\SplPriorityQueue::EXTR_DATA) {
            $value = $valueScoreArray[0];
        } else {
            $value = $valueScoreArray;
        }
        $this->rem($value);
        
        return ($this->flags==\SplPriorityQueue::EXTR_PRIORITY)?$valueScoreArray[1]:$valueScoreArray;
    }
    
    /**
     * @param int flags
     */
    public function setExtractFlags($flags) {
        $this->flags = $flags;
    }
    
}
