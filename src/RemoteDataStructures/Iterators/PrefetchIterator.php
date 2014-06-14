<?php

namespace RemoteDataStructures\Iterators;

/**
 * Iterates over a structure fetching elements in batches.
 * 
 * @author Angel Garbayo
 */
class PrefetchIterator extends CursorIterator {
    
    /** @var int */
    private $remoteIdx = null;
    
    /** @var array Prefetched copy of remote data  */
    private $prefetched = array();
    
    /** @var int Amount of elements to keep in local copy */
    private $prefetch;
    
    /**
     * 
     * @param RedisData $dataStructure
     * @param int $prefetch How many elements to fecth in each batch
     */
    public function __construct($dataStructure, $prefetch = 10) {
        if (!$dataStructure instanceof \RemoteDataStructures\Slice) {
            
        }
        parent::__construct($dataStructure);
        $this->prefetch = $prefetch;
    }
    
    public function rewind() {
        parent::rewind();
        $this->remoteIdx = 0;
        $this->prefetch();
    }
    
    public function current() {
        $offset = $this->remoteIdx - $this->prefetch;
        $prefetchedIdx = $this->key() - $offset;
        if (!isset($this->prefetched[$prefetchedIdx])) {
            $this->prefetch();
            $prefetchedIdx = 0;
        }
        return $this->prefetched[$prefetchedIdx];
    }
    
    private function prefetch() {
        $this->prefetched = $this->dataStructure->slice($this->remoteIdx, $this->remoteIdx+$this->prefetch);
        $this->remoteIdx+=$this->prefetch;
    }

}