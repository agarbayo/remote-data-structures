<?php

namespace RemoteDataStructure;

class PriorityQueueTest extends \PHPUnit_Framework_TestCase
{
    public function testDataFlag()
    {
        $pQueue = new \RemoteDataStructures\RedisPriorityQueue();
        $pQueue->insert(1);
        $pQueue->insert(2);
        $pQueue->insert(3);

        $this->assertEquals(3, $pQueue->extract());
        $this->assertEquals(2, $pQueue->extract());
    }
    
    public function testPriorityFlag()
    {
        $pQueue = new \RemoteDataStructures\RedisPriorityQueue();
        $pQueue->setExtractFlags(\SplPriorityQueue::EXTR_PRIORITY);
        $pQueue->insert(1);
        $pQueue->insert(2);
        $pQueue->insert(3);

        $this->assertEquals(3, $pQueue->extract());
        $this->assertEquals(2, $pQueue->extract());
    }
    
    public function testBothFlag()
    {
        $pQueue = new \RemoteDataStructures\RedisPriorityQueue();
        $pQueue->setExtractFlags(\SplPriorityQueue::EXTR_BOTH);
        $pQueue->insert(1);
        $pQueue->insert(2);
        $pQueue->insert(3);

        $this->assertEquals([3,3], $pQueue->extract());
        $this->assertEquals([2,2], $pQueue->extract());
    }
}

