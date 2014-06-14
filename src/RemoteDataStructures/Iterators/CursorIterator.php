<?php

namespace RemoteDataStructures\Iterators;

/**
 * Iterates fetching one element at a time.
 * Only compatible for structures implementing \Countable and \ArrayAccess
 * 
 * @author Angel Garbayo
 */
class CursorIterator extends RemoteIterator {
    
    /** @var int */
    private $iteratorIdx = null;
    
    public function __construct($dataStructure) {
        if (!$dataStructure instanceof \ArrayAccess || !$dataStructure instanceof \Countable) {
            throw new \InvalidArgumentException("Must implement Countable and ArrayAccess to use CursorIterator");
        }
        parent::__construct($dataStructure);
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
        $cnt = $this->dataStructure->count();
        return ($this->dataStructure->count()-$this->iteratorIdx);
    }

    public function current() {
        return $this->dataStructure->offsetGet($this->iteratorIdx);
    }

}