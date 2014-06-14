<?php

namespace RemoteDataStructures;

/**
 * 
 * @author Angel Garbayo
 */
interface Set {
    
    /**
     * Add element
     */
    public function add($member);
    
    /**
     * Remove element
     */
    public function rem($member);
    
    /**
     * @param mixed $member
     * @return bool 
     */
    public function isMember($member);
    
    /**
     * @return mixed Returns and removes a random member from the set
     */
    public function pop();
    
    /**
     * Removes this structure
     */
    public function delete();
}
