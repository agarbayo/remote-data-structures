<?php

namespace RemoteDataStructure;

class HeapTest extends \PHPUnit_Framework_TestCase
{
    public function testMinHeap()
    {
        $heap = new \RemoteDataStructures\RedisMinHeap();
        $heap->insert(1);
        $heap->insert(2);
        $heap->insert(3);

        $this->assertEquals(1, $heap->extract());
        $this->assertEquals(2, $heap->extract());
    }
    
    public function testMaxHeap()
    {
        $heap = new \RemoteDataStructures\RedisMaxHeap();
        $heap->insert(1);
        $heap->insert(2);
        $heap->insert(3);

        $this->assertEquals(3, $heap->extract());
        $this->assertEquals(2, $heap->extract());
    }
}

