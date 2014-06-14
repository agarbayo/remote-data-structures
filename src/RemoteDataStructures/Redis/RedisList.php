<?php

namespace RemoteDataStructures\Redis;

use RemoteDataStructures\Slice;

/**
 * 
 * @author Angel Garbayo
 */
abstract class RedisList extends RedisData implements \Countable, \ArrayAccess, Slice {
    use RedisCountableList;
    
    public function __construct($key = null, array $conf = null) {
        parent::__construct($key, $conf);
    }
    
     public function offsetExists($index) { 
        return $this->offsetGet($index)!=null;
    }
    
    public function offsetGet($index) { 
        $cmd = $this->redis->createCommand('LINDEX');
        $cmd->setArguments(array($this->key, $index));
        return $this->redis->executeCommand($cmd);
    }
    
    public function offsetSet($index, $newval) { 
        if (empty($index)) {
            $this->push($newval);
        } else {
            $cmd = $this->redis->createCommand('LSET');
            $cmd->setArguments(array($this->key, $index, $newval));
            $this->redis->executeCommand($cmd);
        }
    }
    
    public function offsetUnset($index) { 
        $this->redis->pipeline(function ($pipe) use ($index) {
            $pipe->lset($this->key, $index, 'TOREMOVE');
            $pipe->lrem($this->key, 1, 'TOREMOVE');
        });
    }
    
    public function slice($start, $end) {
            $cmd = $this->redis->createCommand('LRANGE');
            $cmd->setArguments(array($this->key, $start, $end));
            return $this->redis->executeCommand($cmd);
    }
}
