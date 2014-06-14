<?php

namespace RemoteDataStructure\Redis\Spl;

class ObjectStorageTest extends \PHPUnit_Framework_TestCase
{
    public function testObjectStorage()
    {
        $s = new \RemoteDataStructures\Redis\Spl\RedisObjectStorage();
        $o1 = new \StdClass;
        $o2 = new \StdClass;
        
        $s[$o1] = "data for object 1";
        $s[$o2] = array(1,2,3);

        $this->assertEquals("data for object 1", $s[$o1]);
        $this->assertTrue($s->contains($o2));
    }
    
    public function testObjectStorageBulkMethods()
    {
        
    }
}

