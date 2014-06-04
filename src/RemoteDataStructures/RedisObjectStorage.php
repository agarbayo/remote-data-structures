<?php

namespace RemoteDataStructures;

/**
 *
 * @author Angel Garbayo
 */
class RedisObjectStorage extends RedisMap {
    
    public function __construct($key = null, $conf = null) {
       parent::__construct($key, $conf);
    }
    
    public function addAll(RedisObjectStorage $storage) {
        $keys = $storage->keys();
        foreach ($keys as $key) {
            $value = $storage[$key];
            $this->offsetSet($key, $value);
        }
    }
    
    public function attach($object, $data = null) {
        $this->offsetSet($object, $data);
    }
    
    public function detach($object) {
        $this->offsetUnset($object);
    }
    
    public function contains($object) {
        return $this->offsetExists($object);
    }
    
    public function getHash($object) {
        return spl_object_hash($object);
    }
    
    
    public function offsetExists($key) { 
        return parent::offsetExists($this->getHash($key));
    }
    
    public function offsetGet($key) { 
        return unserialize(parent::offsetGet($this->getHash($key)));
    }
    
    public function offsetSet($key, $newval) { 
        parent::offsetSet($this->getHash($key), serialize($newval));
    }
    
    public function offsetUnset($key) { 
        return parent::offsetUnset($this->getHash($key));
    }
    
    public function removeAll(RedisObjectStorage $storage) {
        $keys = $storage->keys();
        $this->bulkUnset($keys);
    }
    
    public function removeAllExcept(RedisObjectStorage $storage) {
        $keys = $this->keys();
        $except = $storage->keys();
        $this->bulkUnset(array_diff($keys, $except));
    }
    
}
