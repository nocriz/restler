<?php

use Api\Client;
use Api\AbstractTest as AbstractTest;

class ClientTest extends AbstractTest
{
    public $instance;

    public function assertPreConditions()
    {	
        $this->assertTrue(
                class_exists($class = 'Api\Client'),
                'Class not found: '.$class
        );
        $this->instance = new Client();
    }

    public function testInstantiationWithoutArgumentsShouldWork(){
        $this->assertInstanceOf('Api\Client', $this->instance);
    }

    /**
    * @depends testInstantiationWithoutArgumentsShouldWork
    */
    public function testSetIdWithValidDataShouldWork()
    {
        $return = $this->instance->setId(1);
        $this->assertInstanceOf('Api\Client', $return);
    }

    /**
    * @depends testInstantiationWithoutArgumentsShouldWork
    */
    public function testGetIdDataShouldWork()
    {
        $this->instance->setId(1);
        $this->assertEquals($this->instance->getId(),1);
    }
}