<?php

namespace RemoteDataStructure;

/**
 *
 * @author Angel Garbayo
 */
class RedisSetTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider sets
     */
    public function testSetDontHaveDuplicateElements(\RemoteDataStructures\Set $set) {
        $set->delete();
        $set->add(1);
        $set->add(2);
        $set->add(2);
        
        $this->assertCount(2, $set);
    }
    
    /**
     * @dataProvider sets
     */
    public function testSetAcceptObjects(\RemoteDataStructures\Set $set) {
        $set->delete();
        $obj = new \stdClass();
        $set->add($obj);
        $obj2 = $set->pop();
        $this->assertEquals($obj, $obj2);
    }
    
    public function sets() {
        return [
            [new \RemoteDataStructures\Local\ArraySet()],
            [new \RemoteDataStructures\Redis\RedisSet()]
            ];
    }
}
