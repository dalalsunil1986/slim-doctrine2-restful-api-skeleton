<?php

namespace App\Service;

use App\Entity\Record;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;

class ProviderService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(EntityManager $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    /**
     * @param array of names to add
     */
    public function addFromArray(array $data)
    {
        if (empty($data)) {
            return;
        }
        foreach ($data as $name) {
            $record = new Record($name);
            $this->em->persist($record);
            $this->logger->debug('Added record' . $record);
        }
        $this->em->flush();
    }
}
