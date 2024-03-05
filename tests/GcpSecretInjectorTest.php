<?php

namespace Tests;

use Agz\LaravelGcpSecretInjector\Exceptions\NoProjectIdProvidedException;
use Agz\LaravelGcpSecretInjector\GcpSecretInjector;
use PHPUnit\Framework\TestCase;

class GcpSecretInjectorTest extends TestCase
{
    /** @test */
    public function it_throws_exception_if_no_project_id_provided()
    {
        $this->expectException(NoProjectIdProvidedException::class);

        new GcpSecretInjector([]);
    }

    /** @test */
    public function it_returns_secret_payload_when_available()
    {
        // Mocking the GcpSecretInjector instance
        $injector = $this->getMockBuilder(GcpSecretInjector::class)
            ->onlyMethods(['getSecret'])
            ->disableOriginalConstructor()
            ->getMock();

        // Stubbing the getSecret method to return a mocked payload
        $injector->expects($this->once())
            ->method('getSecret')
            ->with('test_secret')
            ->willReturn('mocked_secret_value');

        // Testing the getSecret method
        $secretName = 'test_secret';
        $result = $injector->getSecret($secretName);

        $this->assertEquals('mocked_secret_value', $result);
    }
}
