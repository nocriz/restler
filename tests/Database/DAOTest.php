<?php

use Database\DAO\DAO;
use Api\AbstractTest as AbstractTest;
use Database\Sqlite\ConnectorConfig as Sqlite;

class DAOTest extends AbstractTest
{
    public $instance;

    public function assertPreConditions()
    {	
        $this->assertTrue(
                class_exists($class = 'Database\DAO\DAO'),
                'Class not found: '.$class
        );
        $this->instance = new DAO( new Sqlite( 'localhost', 'restler', 'root', '' ) );
    }

    public function testInstantiationWithoutArgumentsShouldWork(){
        $this->assertInstanceOf('Database\DAO\DAO', $this->instance);
    }
}