<?php

namespace RemoteDataStructures;

/**
 * 
 * @author Angel Garbayo
 */
interface Counter {
    
    /**
     * Increments counter
     * @param int $by. If negative decrements the counter
     * @return int New counter value
     */
    public function incr($by = 1);
    
    /**
     * @return int Current value in the counter
     */
    public function get();
    
    /**
     * Removes this structure
     */
    public function delete();
}
