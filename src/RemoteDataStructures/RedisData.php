<?php

namespace RemoteDataStructures;

use Predis\Client;

/**
 *
 * @author Angel Garbayo
 */
abstract class RedisData {
    
    /** @var string */
    protected $key;
    
    /** @var Client */
    protected $redis;
    
    /**
     * 
     * @param string key Key to use in Redis. By default is generates a name based
     *          on the class where the data structure was created
     * @param array $conf
     */
    public function __construct($key = null, array $conf = null) {
        $this->redis = new Client($conf);
        $this->key   =  (empty($key))?$this->genKey():$key;
    }
    
    
    /**
     * Key is name is composer of the package and class name of where this
     * class was instanciated and the class name of the actual instance of RedisData
     * used.
     * 
     * @return string Generate key name
     */
    private function genKey() {
        return get_class($this).'\\'.$this->findCallerClassName();
    }
    
    /**
     * @return string
     */
    private function findCallerClassName() {
        $traceClasses = array_column(debug_backtrace(), 'class');
        foreach ($traceClasses as $classname) {
            if (strpos($classname, 'RemoteDataStructures')===false) {
                return $classname;
            }
        }
        return '';
    }
    
}
