<?php

namespace RemoteDataStructures\Iterators;

/**
 * Base class for all remote iterators
 * 
 * @author Angel Garbayo
 */
abstract class RemoteIterator implements \Iterator {
    
    /** Collection to iterate */ 
    protected $dataStructure;
    
    public function __construct($dataStructure) {
        $this->dataStructure = $dataStructure;
    }
    
}