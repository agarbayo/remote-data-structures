<?php

namespace RemoteDataStructure;

class IteratorsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataStructures
     * @expectedException Exception
     * @param string $iteratorName
     */
    public function testNoIterationIsDefault($dataStructure)
    {
        $fullClass = '\\RemoteDataStructures\\'.$dataStructure;
        $instance  = new $fullClass();
        foreach ($instance as $item) {
            // By default all data structures are not iterable. Should never get here
        }
    }
    
    
    public function dataStructures() {
        return [
                ['RedisDoublyLinkedList'],
                ['RedisFixedArray'],
                ['RedisMaxHeap'],
                ['RedisMinHeap'],
                ['RedisObjectStorage'],
                ['RedisPriorityQueue'],
                ['RedisQueue'],
                ['RedisStack'],
            ];
    }
}

