<?php

namespace App\Service;

use App\Entity\Record;
use Doctrine\ORM\EntityManager;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class ProviderServiceTest extends TestCase
{
    /**
     * @var ProviderService
     */
    private $object;

    /**
     * @var Mockery
     */
    private $em;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function setUp()
    {
        $this->em = m::mock(EntityManager::class);
        $this->logger = m::mock(LoggerInterface::class);
        $this->logger->shouldIgnoreMissing(); // assert if needed

        $this->object = new ProviderService($this->em, $this->logger);
    }

    public function testEmpty()
    {
        $this->em->shouldReceive('persist')->times(0);
        $this->em->shouldReceive('flush')->times(0);

        $this->object->addFromArray([]);

        m::close();
    }

    public function test2records()
    {
        // assert entitities are saved
        $this->em->shouldReceive('persist')->times(1)->with(m::on(function ($e) {
            return $e instanceof Record && $e->getName() === 'r1';
        }));
        $this->em->shouldReceive('persist')->times(1)->with(m::on(function ($e) {
            return $e instanceof Record && $e->getName() === 'r2';
        }));

        $this->em->shouldReceive('flush')->times(1);

        $this->object->addFromArray(['r1', 'r2']);

        m::close();
    }
}
