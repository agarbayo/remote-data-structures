<?php

namespace RemoteDataStructures;

use Predis\Client;

/**
 * 
 * @author Angel Garbayo
 */
abstract class RedisList implements \Countable, \ArrayAccess {
    
    /** @var string */
    protected $key;
    
    /** @var Client */
    protected $redis;
    
    public function __construct(array $conf = null) {
        $this->redis = new Client($conf);
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
