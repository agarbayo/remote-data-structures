<?php

namespace RemoteDataStructure;

/**
 *
 * @author Angel Garbayo
 */
class RedisCounterTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider counters
     */
    public function testSetDontHaveDuplicateElements(\RemoteDataStructures\Counter $cnt) {
        $cnt->delete();
        $this->assertEquals(0, $cnt->get(), "Initial value is 0");
        
        $cnt->incr();
        $this->assertEquals(1, $cnt->get(), "Increments by default 1");
            
        $cnt->incr(2);
        $this->assertEquals(3, $cnt->get(), "Increments by 1 can be overriden");
        
        $cnt->incr(-3);
        $this->assertEquals(0, $cnt->get(), "Negative values decrement the counter");
    }
    
    public function counters() {
        return [
            [new \RemoteDataStructures\Local\Counter()],
            [new \RemoteDataStructures\Redis\RedisCounter()]
            ];
    }
}
