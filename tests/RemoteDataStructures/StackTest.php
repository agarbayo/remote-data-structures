<?php

namespace RemoteDataStructure;

class StackTest extends \PHPUnit_Framework_TestCase
{
    public function testStack()
    {
        $stack = new \RemoteDataStructures\RedisStack();
        $stack->push(1);
        $stack->push(2);

        $this->assertEquals(2, $stack->pop());
        $this->assertEquals(1, $stack->pop());
    }
}

