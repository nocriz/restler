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
        $array = array(
          'application' => array('key'=>'1234567')
        );
        Config::set('application.key','1234567');
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
    public function testGetWithReturnFalseDataShouldWork()
    {
        $this->assertFalse(Config::get('test'));
    }

    /**
    * @depends testInstantiationWithoutArgumentsShouldWork
    */
    public function testGetItemsWithValidFileDataShouldWork()
    {   
        $key = Config::get('settings.key');
        $this->assertEquals('7vEqqJtCQGZ2yHEl2aMjJfGTYoYnqr6z',$key);
    }

    /**
    * @depends testInstantiationWithoutArgumentsShouldWork
    */
    public function testSetWithValidDataShouldWork()
    {   
        $array=array(
            'application'=>array(
                'key' => '1234567'
            ),
            'settings'=>array(
                'key'=> '7vEqqJtCQGZ2yHEl2aMjJfGTYoYnqr6z'
            ),
            'config'=>'12345'
        );
        $key = Config::set('config','12345');
        $this->assertAttributeEquals($array, 'items', $this->instance, 'Attribute was not correctly set');
        $key = Config::get('config');
        $this->assertEquals('12345',$key);
    }
}