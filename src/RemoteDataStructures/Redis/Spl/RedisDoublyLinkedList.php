<?php

namespace RemoteDataStructures\Redis\Spl;

use RemoteDataStructures\Redis\RedisList;

/**
 * Partial implementation of SplDoublyLinkedList.
 * 
 */
class RedisDoublyLinkedList extends RedisList {
    
    /** @var int */
    private $iteratorMode;
    
    /**
     * 
     * @param array $conf Configuration for Redis client
     */
    public function __construct(array $conf = null) {
        parent::__construct($conf);
        $this->iteratorMode = \SplDoublyLinkedList::IT_MODE_FIFO;
    }
    
    /**
     * Convenient method to delete the List from the datastore
     */
    public function delete() {
        $cmd = $this->redis->createCommand('DEL');
        $cmd->setArguments(array($this->key));
        $this->redis->executeCommand($cmd);
    }
    
    public function add($index, $newval) {
        $this->offsetSet($index, $newval);
    }
    
    public function bottom() {
        return $this->offsetGet(0);
    }
    
    public function getIteratorMode() { 
        return $this->iteratorMode;
    }
    
    
    public function isEmpty() { 
        return $this->count() == 0;
    }
    
    
    public function pop() {
        return $this->top();
    }
    
    public function prev() { 
        if (0<$this->iteratorIdx) {
            $this->iteratorIdx--;
        }
    }
    
    public function push($value) {
        $cmd = $this->redis->createCommand('RPUSH');
        $cmd->setArguments(array($this->key, $value));
        $this->redis->executeCommand($cmd);
    }
    
    public function serialize() {
        $cmd = $this->redis->createCommand('LRANGE');
        $cmd->setArguments(array($this->key, 0, -1));
        $list = $this->redis->executeCommand($cmd);
        return serialize($list);
    }
    
    /**
     * 
     * @param int $mode
     */
    public function setIteratorMode($mode) { 
        $this->iteratorMode = $mode;
    }
    
    public function shift() { 
        $cmd = $this->redis->createCommand('LPOP');
        $cmd->setArguments(array($this->key));
        return $this->redis->executeCommand($cmd);  
    }
    
    public function top() { 
        return $this->offsetGet(-1);
    }
    
    public function unserialize($serialized) { 
        $values = unserialize($serialized);
        $cmd = $this->redis->createCommand('RPUSH');
        $args = array_merge([$this->key], $values);
        $cmd->setArguments($args);
        $this->redis->executeCommand($cmd);
    }
    
    public function unshift($value) { 
        $cmd = $this->redis->createCommand('LPUSH');
        $cmd->setArguments(array($this->key, $value));
        return $this->redis->executeCommand($cmd);  
    }
    
}
