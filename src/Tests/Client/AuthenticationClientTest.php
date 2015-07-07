<?php

namespace Humantech\Zoho\Recruit\Api\Tests\Client;

use GuzzleHttp\Psr7\Response;

class AuthenticationClientTest extends ClientTestCase
{
    public function testInheritedAbstractClient()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Client\\AuthenticationClient'
        );

        $this->assertEquals(
            'Humantech\\Zoho\\Recruit\\Api\\Client\\AbstractClient',
            $reflection->getParentClass()->getName()
        );
    }

    public function testImplementsAuthenticationClientInterface()
    {
        $reflection = new \ReflectionClass(
            '\\Humantech\\Zoho\\Recruit\\Api\\Client\\AuthenticationClient'
        );

        $this->assertTrue($reflection->implementsInterface(
            '\\Humantech\\Zoho\\Recruit\\Api\\Client\\AuthenticationClientInterface'
        ));
    }

    public function testGetApiResponseAuthToken()
    {
        $client = $this->getMockBuilder('\\Humantech\\Zoho\\Recruit\\Api\\Client\\AuthenticationClient')
            ->setMethods(array('sendRequest'))
            ->getMock()
        ;

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->willReturn(new Response(200, array(), 'fakeContent'))
        ;

        $this->assertEquals('fakeContent', $this->invokeMethod($client, 'getApiResponseAuthToken', array('fake_user', 'fake_pwd')));
    }

    public function testGenerateAuthToken()
    {
        $client = $this->getMockBuilder('\\Humantech\\Zoho\\Recruit\\Api\\Client\\AuthenticationClient')
            ->setMethods(array('getApiResponseAuthToken'))
            ->getMock()
        ;

        $client
            ->expects($this->once())
            ->method('getApiResponseAuthToken')
            ->willReturn($this->getResourceFakeResponseByName('authentication.txt'))
        ;

        $this->assertEquals('df82957e4c13f2d9a1efd2788bf6baa0', $client->generateAuthToken('fake_user', 'fake_pwd'));
    }

    /**
     * @expectedException \Humantech\Zoho\Recruit\Api\Client\AuthenticationClientException
     */
    public function testGenerateAuthTokenErrorExceededMaximumAllowedAuthTokens()
    {
        $client = $this->getMockBuilder('\\Humantech\\Zoho\\Recruit\\Api\\Client\\AuthenticationClient')
            ->setMethods(array('getApiResponseAuthToken'))
            ->getMock()
        ;

        $client
            ->expects($this->once())
            ->method('getApiResponseAuthToken')
            ->willReturn($this->getResourceFakeResponseByName('authentication_error.txt'))
        ;

        $client->generateAuthToken('fake_user', 'fake_pwd');
    }
}
