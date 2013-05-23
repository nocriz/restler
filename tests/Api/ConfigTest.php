<?php

use Api\Config;
use Api\AbstractTest as AbstractTest;

class ConfigTest extends AbstractTest
{
    public $instance;

    public function assertPreConditions()
    {	
        $this->assertTrue(
                class_exists($class = 'Api\Config'),
                'Class not found: '.$class
        );
        $this->instance = new Config();
    }

    public function testInstantiationWithoutArgumentsShouldWork(){
        $this->assertInstanceOf('Api\Config', $this->instance);
    }

    /**
    * @depends testInstantiationWithoutArgumentsShouldWork
    */
    public function testSetItemsWithValidDataShouldWork()
    {
        $item = 'application.key';
        $array = array(
          'application' => array('key'=>'1234567')
        );
        Config::set($item,'1234567');
        //$this->assertEquals($instance, $return, 'Returned value should be the same instance for fluent interface');
        $this->assertAttributeEquals($array, 'items', $this->instance, 'Attribute was not correctly set');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Empty key or value not allowed
     */
    public function testSetWithInvalidDataShouldThrownAnException()
    {
        $invalidSet = '';
        Config::set($invalidSet);
    }

    /**
    * @depends testInstantiationWithoutArgumentsShouldWork
    */
    public function testGetItemsWithValidDataShouldWork()
    {
        Config::set('application.key','1234567');
        
        $array = array(
          'application' => array('key'=>'1234567')
        );
        
        $key = Config::get('application.key');
        $this->assertEquals('1234567',$key);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Empty key not allowed
     */
    public function testGetWithInvalidDataShouldThrownAnException()
    {
        $invalidGet = '';
        Config::get($invalidGet);
    }

    /**
    * @depends testInstantiationWithoutArgumentsShouldWork
    */
    public function testGetItemsWithValidFileDataShouldWork()
    {   
        $key = Config::get('settings.key');
        $this->assertEquals('7vEqqJtCQGZ2yHEl2aMjJfGTYoYnqr6z',$key);
    }
}