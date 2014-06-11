<?php

namespace RemoteDataStructures\Iterators;

/**
 *
 * @author angel
 */
class CursorIterator extends RemoteIterator {
    
    /** @var int */
    private $iteratorIdx = null;
    
    private $dataStructure;
    
    public function __construct($dataStructure) {
        $this->dataStructure = $dataStructure;
    }
    
    public function key() {
        return $this->iteratorIdx;
    }
    public function next() { 
        if ($this->valid()) {
            $this->iteratorIdx++;
        }
    }
    
    public function rewind() {
        $this->iteratorIdx = 0;
    }
    
    public function valid() { 
        return ($this->dataStructure->count()-1>$this->iteratorIdx);
    }

    public function current() {
        return $this->dataStructure->offsetGet($this->iteratorIdx);
    }

}