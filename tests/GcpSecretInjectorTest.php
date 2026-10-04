<?php

namespace Tests;

use Agz\LaravelGcpSecretInjector\Exceptions\NoProjectIdProvidedException;
use Agz\LaravelGcpSecretInjector\GcpSecretInjector;
use Agz\LaravelGcpSecretInjector\ReloadConfiguration;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;
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

    /** @test */
    public function it_reloads_configuration_files_when_configuration_is_cached()
    {
        $basePath = sys_get_temp_dir() . '/gcp-secret-injector-' . uniqid();
        mkdir($basePath . '/bootstrap/cache', 0777, true);
        mkdir($basePath . '/config', 0777, true);

        file_put_contents($basePath . '/bootstrap/cache/config.php', '<?php return [\'app\' => [\'env\' => \'testing\', \'timezone\' => \'UTC\'], \'services\' => [\'api_key\' => null]];');
        file_put_contents($basePath . '/config/app.php', '<?php return [\'env\' => \'testing\', \'timezone\' => \'UTC\'];');
        file_put_contents($basePath . '/config/services.php', '<?php return [\'api_key\' => env(\'API_KEY\')];');

        $app = new Application($basePath);
        (new LoadConfiguration())->bootstrap($app);

        $this->assertNull($app['config']->get('services.api_key'));

        $_ENV['API_KEY'] = 'injected-secret';
        (new ReloadConfiguration())->reload($app);

        $this->assertSame('injected-secret', $app['config']->get('services.api_key'));

        unset($_ENV['API_KEY']);
        unlink($basePath . '/bootstrap/cache/config.php');
        unlink($basePath . '/config/app.php');
        unlink($basePath . '/config/services.php');
        rmdir($basePath . '/bootstrap/cache');
        rmdir($basePath . '/bootstrap');
        rmdir($basePath . '/config');
        rmdir($basePath);
    }
}
