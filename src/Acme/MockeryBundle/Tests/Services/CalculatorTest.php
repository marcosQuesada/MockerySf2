<?php
/**
 * Created by JetBrains PhpStorm.
 * User: marcos
 * Date: 10/12/12
 * Time: 22:53
 * To change this template use File | Settings | File Templates.
 */
use \Mockery;
use Acme\MockeryBundle\Services\Calculator;

class CalculatorTest extends PHPUnit_Framework_TestCase
{

    public function testGetsAverageValueFromServiceDataValuesOnPHPUnitMock()
    {
        $service = $this->getMockBuilder('Acme\\MockeryBundle\\Services\\MainService')
            ->getMock();
        $service->expects($this->once())
            ->method('getValues')
            ->will($this->returnValue(array(10, 12, 14)))
        ;

        $calculatedValues = new Calculator($service);
        $this->assertEquals(12, $calculatedValues->average());
        ;
    }

    public function testGetsAverageValueFromServiceDataValuesFromQuickDefinitionMock()
    {
        $service = Mockery::mock('Acme\\MockeryBundle\\Services\\MainService',
            array('getValues'=>array(10, 12, 14))
        );

        $calculatedValues = new Calculator($service);
        $this->assertEquals(12, $calculatedValues->average());
    }

    /**
     * Calculator is the class under test, we want to create a Service Mock
     * and assert average method
     *
     */
    public function testGetsAverageValueFromServiceDataValues()
    {
        $service = Mockery::mock('Acme\\MockeryBundle\\Services\\MainService');
        $service->shouldReceive('getValues')
                 ->times(1)
                 ->andReturn(array(10, 12, 14));

        $calculatedValues = new Calculator($service);
        $this->assertEquals(12, $calculatedValues->average());
    }

    /**
     * Mocks generate 4 different response
     * one at a time as a secuence
     * Every time getValues is called returns next item on list
     *
     */
    public function testGetsMediaValuesFromServiceDataValues()
    {
        $service = Mockery::mock('service');
        $service->shouldReceive('getValues')
            ->times(4)
            ->andReturn(1, 2, 3, 4);

        $calculatedValues = new Calculator($service);
        $this->assertEquals(10, $calculatedValues->sumatory());
    }


    public function testValidationTypeHintingWithMockery()
    {
        $mock = Mockery::mock('Acme\\MockeryBundle\\Services\\MainService');

        $this->assertTrue( $mock instanceof Acme\MockeryBundle\Services\MainService);

    }

    public function testValidationTypeHintingWithMockeryFromInstanceObject()
    {
        $mainService = new Acme\MockeryBundle\Services\MainService();

        $mock = Mockery::mock($mainService);

        $this->assertTrue( $mock instanceof Acme\MockeryBundle\Services\MainService);

    }

    public function testPartialMockFromInstanceObjectHasOriginalDefinedMethods()
    {
        $mock = Mockery::mock(
            new Acme\MockeryBundle\Services\MainService()
        );

        $this->assertEquals($mock->test(), 'Original Method Response');

    }

    public function testPartialMockFromInstanceObjectToOverrideOriginalDefinedMethods()
    {
        $mock = Mockery::mock(
            new Acme\MockeryBundle\Services\MainService(),
            array('test'=>'Override Method Response')
        );

        $this->assertEquals($mock->test(), 'Override Method Response');

    }

    public function testToReturnHisOwnInstanceOnNextMockMethodCall()
    {
        $mock = Mockery::mock('Acme\MockeryBundle\Services\MainService');

        $mock->shouldReceive('next')
            ->andReturn($mock)
            ->mock();

        $calculatedValues = new Calculator($mock);

        $this->assertTrue( $calculatedValues->getNextObj() instanceof Acme\MockeryBundle\Services\MainService);
    }

    public function teardown()
    {
        Mockery::close();

        $mock = \Mockery::mock('stdClass, MyInterface1, MyInterface2');


    }
}





























