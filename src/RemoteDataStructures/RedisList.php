<?php

namespace RemoteDataStructures;

/**
 * 
 * @author Angel Garbayo
 */
abstract class RedisList extends RedisData implements \Countable, \ArrayAccess {
    
    public function __construct($key = null, array $conf = null) {
        parent::__construct($key, $conf);
    }
    
    public function count() {
        $cmd = $this->redis->createCommand('LLEN');
        $cmd->setArguments(array($this->key));
        return $this->redis->executeCommand($cmd);
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
}
