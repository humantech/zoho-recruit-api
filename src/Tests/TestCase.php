<?php

namespace Humantech\Zoho\Recruit\Api\Tests;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call.
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Setup protected/private property of a class.
     *
     * @param object &$object       Instantiated object that we will run method on.
     * @param string $propertyName  Property name to setup.
     * @param mixed  $propertyValue New value of the property with the visibility private or protected.
     *
     * @return \ReflectionClass
     */
    public function propertySetValue(&$object, $propertyName, $propertyValue)
    {
        $reflection = new \ReflectionClass(get_class($object));
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);

        $property->setValue($object, $propertyValue);

        return $reflection;
    }

    /**
     * Get a value of protected/private property of a class.
     *
     * @param object &$object       Instantiated object that we will run method on.
     * @param string $propertyName  Property name.
     *
     * @return mixed
     */
    public function propertyGetValue(&$object, $propertyName)
    {
        $reflection = new \ReflectionClass(get_class($object));
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);

        return $property->getValue($object);
    }
}
