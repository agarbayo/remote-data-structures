<?php

namespace RemoteDataStructure\Iterators;

class PrefetchIteratorTest extends \PHPUnit_Framework_TestCase {
    
    public function testTraverseWithPrefetchIterator() {
        $list = new \RemoteDataStructures\Redis\Spl\RedisDoublyLinkedList();
        $list->delete();
        $list->setIteratorType('PrefetchIterator');
        $data = [1, 2, 3, 4, 5, 6];
        foreach ($data as $v) {
            $list[] = $v;
        }   

        foreach ($list as $elem) {
            $v = array_shift($data);
            $this->assertEquals($v, $elem);
        }
    }
}

