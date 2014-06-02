<?php

namespace RemoteDataStructure;

class QueueTest extends \PHPUnit_Framework_TestCase
{
    public function testQueue()
    {
        $queue = new \RemoteDataStructures\RedisQeue();
        $queue->enqueue(1);
        $queue->enqueue(2);

        $this->assertEquals(1, $queue->dequeue());
        $this->assertEquals(2, $queue->dequeue());
    }
}

