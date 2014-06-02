<?php

namespace RemoteDataStructure;

class DoublyLinkedListTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * @dataProvider dummyArray
     */
    public function testCount(array $dummyArray, $list) {
        $this->assertCount(count($dummyArray), $list);
    }
    
    /**
     * @dataProvider dummyArray
     */
    public function testTraverse(array $dummyArray, $list) {
        foreach ($list as $value) {
            $this->assertEquals(array_shift($dummyArray), $value);
        }
    }
    
    /**
     * @dataProvider dummyArray
     */
    public function atestTraverseBackwards(array $dummyArray, $list) {
        $list->setIteratorMode(\SplDoublyLinkedList::IT_MODE_LIFO);
        foreach ($list as $value) {
            $this->assertEquals(array_pop($dummyArray), $value);
        }
    }
    
    /**
     * @dataProvider dummyArray
     */
    public function testDelete(array $dummyArray, $list) {
         unset($list[1]);
        list($v1, $v2) = $list;
        $this->assertEquals($dummyArray[0], $v1);
        $this->assertEquals($dummyArray[2], $v2);
        
        $list->delete();
        // traverse empty list
        foreach ($list as $value) {
            print "Exception thrown!!! \n";
            throw new Exception("Should never iterate over an empty list");
       }
        $this->assertEmpty($list);
    }
    
    /**
     * FIXME For some reason dataProvider annotation failed on this text
     */
    public function testInsertAt() {
        list(list($dummyArray, $list)) = $this->dummyArray();
        
        $list[1] = $dummyArray[0];
        $list[2] = $dummyArray[0];
        foreach ($list as $v) {
            $this->assertEquals($dummyArray[0], $v);
        }
        
    }
    
    public function testSerialize() {
        $this->markTestIncomplete();
    }
    
    public function dummyArray() {
        $dummyArray = [1, 2, 3];
        
        $list = new \RemoteDataStructures\RedisDoublyLinkedList();
        $list->delete();
        foreach ($dummyArray as $v) {
            $list[] = $v;
        }   
    
        return [[$dummyArray, $list]];
    }
}

