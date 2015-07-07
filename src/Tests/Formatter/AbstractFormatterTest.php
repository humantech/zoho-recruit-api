<?php

namespace Humantech\Zoho\Recruit\Api\Tests\Formatter;

use Humantech\Zoho\Recruit\Api\Tests\TestCase;

class AbstractFormatterTest extends TestCase
{
    protected function getAbstractFormatterMock()
    {
        return $this->getMockBuilder('\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\AbstractFormatter')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass()
        ;
    }

    public function testIsAbstractClass()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\AbstractFormatter'
        );

        $this->assertTrue($reflection->isAbstract());
    }

    public function testImplementsFormatterInterface()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\AbstractFormatter'
        );

        $this->assertTrue($reflection->implementsInterface(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\FormatterInterface'
        ));
    }

    public function testConstructIsNotPublic()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\AbstractFormatter'
        );

        $this->assertFalse($reflection->getConstructor()->isPublic());
    }

    public function testCreate()
    {
        $instance = $this->getAbstractFormatterMock()->create('fake_module', 'fake_method');

        $this->assertInstanceOf(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\AbstractFormatter',
            $instance
        );
    }

    public function testCreateVisibility()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\AbstractFormatter'
        );

        $this->assertTrue($reflection->getMethod('create')->isPublic());

        $this->assertTrue($reflection->getMethod('create')->isStatic());
    }

    public function testIsModule()
    {
        $instance = $this->getAbstractFormatterMock()->create('fake_module', 'fake_method');

        $this->assertTrue($this->invokeMethod($instance, 'isModule', array('fake_module')));
    }

    public function testGetModule()
    {
        $instance = $this->getAbstractFormatterMock()->create('fake_module', 'fake_method');

        $this->assertEquals(
            'fake_module',
            $this->invokeMethod($instance, 'getModule')
        );
    }

    public function testIsMethod()
    {
        $instance = $this->getAbstractFormatterMock()->create('fake_module', 'fake_method');

        $this->assertTrue($this->invokeMethod($instance, 'isMethod', array('fake_method')));
    }

    public function testGetMethod()
    {
        $instance = $this->getAbstractFormatterMock()->create('fake_module', 'fake_method');

        $this->assertEquals(
            'fake_method',
            $this->invokeMethod($instance, 'getMethod')
        );
    }

    public function testSetFormatter()
    {
        $instance = $this->getAbstractFormatterMock()->create('fake_module', 'fake_method');

        $formatter = $this->getMockBuilder('\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\FormatterInterface')->getMock();

        $this->assertInstanceOf(
            '\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\AbstractFormatter',
            $this->invokeMethod($instance, 'setFormatter', array($formatter))
        );
    }

    public function testGetFormatter()
    {
        $instance = $this->getAbstractFormatterMock()->create('fake_module', 'fake_method');

        $formatter = $this->getMockBuilder('\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\FormatterInterface')->getMock();

        $formatter
            ->expects($this->once())
            ->method('getOutput')
            ->will($this->returnValue('fakeOutput'))
        ;

        $this->invokeMethod($instance, 'setFormatter', array($formatter));

        $this->assertEquals('fakeOutput', $this->invokeMethod($instance, 'getFormatter')->getOutput());
    }

    public function testGetOriginalData()
    {
        $instance = $this->getAbstractFormatterMock()->create('fake_module', 'fake_method');

        $this->assertEmpty($this->invokeMethod($instance, 'getOriginalData'));

        $this->assertTrue(is_array($this->invokeMethod($instance, 'getOriginalData')));
    }

    public function testGetOutput()
    {
        $instance = $this->getAbstractFormatterMock()->create('fake_module', 'fake_method');

        $this->assertEmpty($this->invokeMethod($instance, 'getOutput'));

        $this->assertTrue(is_array($this->invokeMethod($instance, 'getOutput')));
    }

    public function testGetOutputFromFormatter()
    {
        $instance = $this->getAbstractFormatterMock()->create('fake_module', 'fake_method');

        $formatter = $this->getMockBuilder('\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\FormatterInterface')->getMock();

        $formatter
            ->expects($this->once())
            ->method('getOutput')
            ->will($this->returnValue('Fake message!'))
        ;

        $this->invokeMethod($instance, 'setFormatter', array($formatter));

        $this->assertEquals('Fake message!', $this->invokeMethod($instance, 'getOutput'));
    }

    /**
     * @expectedException \Humantech\Zoho\Recruit\Api\Client\HttpApiException
     */
    public function testGetOutputHttpApiException()
    {
        $instance = $this->getAbstractFormatterMock()->create('fake_module', 'fake_method');

        $formatter = $this->getMockBuilder('\\Humantech\\Zoho\\Recruit\\Api\\Formatter\\Response\\ErrorResponseFormatter')->getMock();

        $formatter
            ->expects($this->once())
            ->method('getOutput')
            ->will($this->returnValue(array(
                'code'    => 1,
                'message' => 'Message',
                'uri'     => 'http://fake',
            )))
        ;

        $this->invokeMethod($instance, 'setFormatter', array($formatter));

        $this->invokeMethod($instance, 'getOutput');
    }
}
