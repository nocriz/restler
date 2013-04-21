<?php

use Api\Client;
use Api\AbstractTest as AbstractTest;

class ClientTest extends AbstractTest
{
    public function assertPreConditions()
    {	
        $this->assertTrue(
                class_exists($class = 'Api\Client'),
                'Class not found: '.$class
        );
    }

    public function testInstantiationWithoutArgumentsShouldWork(){
        $instance = new Client();
        $this->assertInstanceOf('Api\Client', $instance);
    }

    /**
    * @depends testInstantiationWithoutArgumentsShouldWork
    */
    public function testSetItemsWithValidDataShouldWork()
    {
        $instance = new Client();
    }
}