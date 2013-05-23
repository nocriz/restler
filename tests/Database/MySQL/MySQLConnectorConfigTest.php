<?php

use Database\MySQL\ConnectorConfig;
use Api\AbstractTest as AbstractTest;

class MySQLConnectorConfigTest extends AbstractTest {
	
	public $instance;

	public function assertPreConditions()
    {	
        $this->assertTrue(
                class_exists($class = 'Database\MySQL\ConnectorConfig'),
                'Class not found: '.$class
        );
        $this->instance = new ConnectorConfig('localhost','test','root','');
    }

    public function testInstantiationWithArgumentsShouldWork(){
        $this->assertInstanceOf('Database\MySQL\ConnectorConfig', $this->instance);
    }

    /**
    * @depends testInstantiationWithArgumentsShouldWork
    */
    public function testReturnStringConnectDB()
    {
        $this->assertEquals($this->instance->get_DSN(),'mysql:host=localhost;dbname=test');
    }

    /**
    * @depends testInstantiationWithArgumentsShouldWork
    */
    public function testReturnHost()
    {
        $this->assertEquals($this->instance->get_host(),'localhost');
    }

    /**
    * @depends testInstantiationWithArgumentsShouldWork
    */
    public function testReturnPassword()
    {
        $this->assertEquals($this->instance->get_password(),'');
    }

    /**
    * @depends testInstantiationWithArgumentsShouldWork
    */
    public function testReturnName()
    {
        $this->assertEquals($this->instance->get_name(),'test');
    }

    /**
    * @depends testInstantiationWithArgumentsShouldWork
    */
    public function testReturnUser()
    {
        $this->assertEquals($this->instance->get_user(),'root');
    }
}