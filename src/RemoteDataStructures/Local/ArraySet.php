<?php

namespace RemoteDataStructures\Local;

/**
 * Set implemented with PHP array
 * 
 * @author Angel Garbayo
 */
class ArraySet implements \Countable, \RemoteDataStructures\Set {
    
    /** @var array */
    private $data;
    
    public function __construct() {
        $this->data = [];
    }
    
    public function count() {
        return count($this->data);
    }
    
    public function add($member) {
        $this->data[$this->getKey($member)] = $member;
    }
    
    public function pop() {
        return array_pop($this->data);
    }
    
    /**
     * Remove element
     */
    public function rem($member) {
        unset($this->data[$this->getKey($member)]);
    }
    
    /**
     * @param mixed $member
     * @return bool 
     */
    public function isMember($member) {
        return isset($this->data[$this->getKey($member)]);
    }
    
    public function delete() {
        $this->data = [];
    }
    
    /**
     * Generates a valid string to use as array key
     * 
     * @param mixed $member
     * @return string Valid key
     */
    private function getKey($member) {
        return is_object($member)?spl_object_hash($member):$member;
    }
    
    
}
