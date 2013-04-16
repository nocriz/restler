<?php

use Api\Say;
use Api\AbstractTest as AbstractTest;

class ConfigTest extends AbstractTest
{
    public function assertPreConditions()
    {	
        $this->assertTrue(
                class_exists($class = 'Api\Say'),
                'Class not found: '.$class
        );
    }

    public function testInstantiationWithoutArgumentsShouldWork(){
        $instance = new Say();
        $this->assertInstanceOf('Api\Say', $instance);
    }

    /**
    * @depends testInstantiationWithoutArgumentsShouldWork
    */
    public function testSetItemsWithValidDataShouldWork()
    {
        $instance = new Say();
        $to = 'world';
        $return = $instance->hello($to);
        $this->assertEquals('Hello world!',$return);
    }
}