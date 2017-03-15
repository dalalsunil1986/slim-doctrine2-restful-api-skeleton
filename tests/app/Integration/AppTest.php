<?php

namespace App\Service;

use App\Entity\Record;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Slim\Http\Request;
use Slim\Http\Response;

class AppTest extends TestCase
{
    /**
     * @var \Slim\App
     */
    private $app;

    public function setUp()
    {
        // drop and recreate database
        echo 'Dropping and recreating test database';
        exec('UNIT_TEST_MODE=1 vendor/bin/doctrine orm:schema-tool:drop --force');
        exec('UNIT_TEST_MODE=1 vendor/bin/doctrine orm:schema-tool:create');

        // instantiate app with dbxyz_test db
        $unitTestMode = true;
        $settings = require __DIR__ . '/../../../app/settings.php';
        $app = new \Slim\App($settings);
        require __DIR__ . '/../../../app/dependencies.php';
        require __DIR__ . '/../../../app/routes.php';

        $this->app = $app;
    }

    public function testPostProviders()
    {
        $router = $this->app->getContainer()->get('router'); /* @var $router \Slim\Router */
        $route = $router->getRoutes()['route0']; /* @var $route \Slim\Route */
        $request = m::mock(Request::class);
        $request->shouldReceive('getBody')->andReturn(json_encode(['r1', 'r2']));
        $response = new Response();
        $route->run($request, $response);

        $em = $this->app->getContainer()->get('em');
        $em->clear();
        $records = $em->getRepository(Record::class)->findAll();

        // assert records flushed
        $this->assertCount(2, $records);
    }
}
