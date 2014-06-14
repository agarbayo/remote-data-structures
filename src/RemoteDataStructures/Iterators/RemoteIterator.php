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
    
    /**
     * 
     * @param string $iteratorName Short iterator name. Eg 'NoIterator'
     * @return string Full class name for an iterator. Eg. '\RemoteDataStructures\Iterators\NoIterator'
     * @throws \InvalidArgumentException When iterator does not exist or is not valid RemoteIterator
     */
    public static function getFullClassFromName($iteratorName) {
        $iteratorClass = '\RemoteDataStructures\Iterators\\'.$iteratorName;
        if (!is_subclass_of($iteratorClass, '\RemoteDataStructures\Iterators\RemoteIterator')) {
            throw new \InvalidArgumentException("Iterator $iteratorClass is not a valid remote iterator");
        }
        return $iteratorClass;
    }
    
}