<?php

namespace RemoteDataStructure;

use RemoteDataStructures\Redis\RedisConfiguration;

/**
 *
 * @author Angel Garbayo
 */
class RedisSetTest extends \PHPUnit_Framework_TestCase {
    
    public function testRedisDefaultParameters() {
        // Should be default to localhost
        $c = RedisConfiguration::getParameters();
        $this->assertNull($c);
        
        // Should be newly assigned conf
        RedisConfiguration::setParameters([
            'scheme' => 'tcp',
            'host'   => '10.0.0.1',
            'port'   => 6379,
        ]);
        $c = RedisConfiguration::getParameters();
        $this->assertEquals('10.0.0.1', $c['host']);
    }
    
    public function testConfigurationParametersByKey() {
        $key = '\RemoteDataStructures\RedisMinHeapTest';
        RedisConfiguration::setParameters([
            'host'   => '192.168.0.1',
        ],
        $key);
        
        $c = RedisConfiguration::getParameters($key);
        $this->assertEquals('192.168.0.1', $c['host']);
        
        $defaultC = RedisConfiguration::getParameters();
        $this->assertNull($defaultC);
    }
    
    protected function tearDown() {
        RedisConfiguration::setParameters(null);
    }
}
