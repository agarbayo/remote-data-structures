<?php

namespace RemoteDataStructure;

class FixedArrayTest extends \PHPUnit_Framework_TestCase
{
    public function testFixedArray()
    {
        $arr = new \RemoteDataStructures\RedisFixedArray(5);
        $arr[1] = 1;
        $arr[2] = 2;

        $this->assertEquals(1, $arr[1]);
        $this->assertEquals(2, $arr[2]);
    }
}

