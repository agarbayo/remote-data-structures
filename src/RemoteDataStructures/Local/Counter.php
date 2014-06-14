<?php

namespace RemoteDataStructures\Local;

/**
 * Counter implemented in PHP
 * 
 * @author Angel Garbayo
 */
class Counter implements \RemoteDataStructures\Counter {
    
    /** @var int */
    private $value;
    
    public function __construct() {
        $this->value = 0;
    }

    public function delete() {
        $this->value = 0;
    }

    public function get() {
        return $this->value;
    }

    public function incr($by = 1) {
        $this->value+=$by;
    }

}
