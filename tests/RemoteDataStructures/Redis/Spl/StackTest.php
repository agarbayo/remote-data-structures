<?php

namespace RemoteDataStructure\Redis\Spl;

class StackTest extends \PHPUnit_Framework_TestCase
{
    public function testStack()
    {
        $stack = new \RemoteDataStructures\Redis\Spl\RedisStack();
        $stack->push(1);
        $stack->push(2);

        $this->assertEquals(2, $stack->pop());
        $this->assertEquals(1, $stack->pop());
    }
}

