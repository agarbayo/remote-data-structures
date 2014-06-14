<?php

namespace RemoteDataStructures;

/**
 * Classes implementing Slice can be used to retrieve a range of elements
 * at once.
 * 
 * @author Angel Garbayo
 */
interface Slice {
    
    /**
     * Retrieve a range of elements
     * 
     * @param int $start
     * @param int $end
     * @return array Elements between start and end
     */
    public function slice($start, $end);
}
