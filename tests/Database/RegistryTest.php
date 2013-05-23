<?php

use Database\Registry;
use Api\AbstractTest as AbstractTest;

class RegistryTest extends AbstractTest
{
    public $instance;

    public function assertPreConditions()
    {	
        $this->assertTrue(
                class_exists($class = 'Database\Registry'),
                'Class not found: '.$class
        );
        $this->instance = Registry::getInstance();
    }

    public function testInstantiationWithoutArgumentsShouldWork(){
        $this->assertInstanceOf('Database\Registry', $this->instance);
    }

    /**
    * @depends testInstantiationWithoutArgumentsShouldWork
    */
    public function testSetRegistryWithValidDataShouldWork()
    {
        $data = array(1);
        $this->instance->set('teste1',$data);
        $comp = new \ArrayObject();
        $comp->offsetSet( 'teste1' , $data );
        $this->assertAttributeEquals($comp, 'storage', $this->instance, 'Attribute was not correctly set');
    }

    /**
     * @expectedException LogicException
     * @expectedExceptionMessage Já existe um registro para a chave "teste1".
     */
    public function testSetRegistryWithInvalidDataShouldWork()
    {
        $data = array(1);
        $this->instance->set('teste1',$data);
        $this->instance->set('teste1',1);
    }

    /**
    * @depends testInstantiationWithoutArgumentsShouldWork
    */
    public function testGetRegistryWithValidDataShouldWork()
    {
        $data = array(1);
        $this->instance->set('teste2',$data);
        $this->assertEquals($this->instance->get('teste2'),array(1));
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage Não existe um registro para a chave "teste3".
     */
    public function testUnregisterRegistryDataShouldThrownAnException()
    {
        $this->instance->set('teste3',1);
        $this->instance->unregister('teste3');
        $this->instance->get('teste3');
    }

    public function testCloneRegistryDataShouldThrownAnException()
    {
        $this->setExpectedException('PHPUnit_Framework_Error');
        $clone = clone Registry::getInstance();
    }
}