<?php

namespace RemoteDataStructures;

use Predis\Client;
use RemoteDataStructures\Iterators\NoIterator;

/**
 * Common structures and fields to all data structures backed by Redis
 *
 * @author Angel Garbayo
 */
abstract class RedisData implements \IteratorAggregate {
    
    /** @var string */
    protected $key;
    
    /** @var Client */
    protected $redis;
    
    /** @var Traversable */
    protected $iterator;
    
    /**
     * 
     * @param string key Key to use in Redis. By default is generates a name based
     *          on the class where the data structure was created
     * @param array $conf
     */
    public function __construct($key = null, array $conf = null) {
        $this->key   =  (empty($key))?$this->genKey():$key;
        $this->iterator = new \RemoteDataStructures\Iterators\NoIterator($this);
        $conf        = $conf==null?RedisConfiguration::getParameters($this->key):$conf;
        $this->redis = new Client($conf);
    }
    
    public function getIterator() {
        return $this->iterator;
    }
    
    /**
     * Assigns a remote iterator.
     * 
     * By design all remote data structures lack a valid iterator, the iteration policy
     * used over the remote data structure must be chosen explicitly for each instance
     * with this function.
     * 
     * @param string $iteratorName Name of the iterator. eg. 'CopyIterator'
     * @throws \InvalidArgumentException
     */
    public function setIteratorType($iteratorName) {
        $iteratorClass = '\RemoteDataStructures\Iterators\\'.$iteratorName;
        if (!is_subclass_of($iteratorClass, '\RemoteDataStructures\Iterators\RemoteIterator')) {
            throw new \InvalidArgumentException("Iterator $iteratorClass is not a valid remote iterator");
        }
        
        $this->iterator = new $iteratorClass($this);
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
     * @return string Class name where the function calling this name is located.
     *                Empty string is no suitable class was found
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
