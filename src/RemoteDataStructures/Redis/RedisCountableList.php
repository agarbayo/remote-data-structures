<?php

namespace RemoteDataStructures\Redis;

/**
 * Encapsulate counting number of elements in a RedisList
 * 
 * @author Angel Garbayo
 */
trait RedisCountableList {
    
    
    public function count() {
        $cmd = $this->redis->createCommand('LLEN');
        $cmd->setArguments(array($this->key));
        return $this->redis->executeCommand($cmd);
    }
    
}
