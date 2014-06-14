<?php

namespace RemoteDataStructures\Redis\Spl;

use RemoteDataStructures\Redis\RedisList;

/**
 * Remote fixed array backed by Redis list..
 * 
 * @author Angel Garbayo
 */
class RedisFixedArray extends RedisList {
    
    /** @var int Array fixed size */
    private $size = 0;
    
    public function __construct($size = 0, array $conf = null) {
        parent::__construct($conf);
        $this->setSize($size);
    }
    
    public function getSize() {
        $this->size;
    }
    
    public function setSize($size) {
        // Initialize to null values so that lset works in later operatios
        $this->growList($size - $this->size);
        $this->size = $size;
    }
    
    public function offsetSet($index, $newval) {
        parent::offsetSet($index, $newval);
        $cmd = $this->redis->createCommand('LTRIM');
        $cmd->setArguments(array($this->key, 0, $this->size));
        $this->redis->executeCommand($cmd);
    }
    
    /**
     * 
     * @param int $sizeDiff
     */
    private function growList($sizeDiff) {
        if ($sizeDiff > 0) {
            $cmd = $this->redis->createCommand('LPUSH');
            $args = array_merge([$this->key], array_fill(0, $sizeDiff, null));
            $cmd->setArguments($args);
            $this->redis->executeCommand($cmd);
        }
    }
}
