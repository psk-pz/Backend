<?php

namespace ApiV1Bundle\Tests\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use ApiV1Bundle\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Integration tests covering repository.
 */
class TicketRepositoryTest extends KernelTestCase
{
    /** @var TicketRepository */
    private $repository;

    /**
     * Prepares environment for executing tests.
     */
    public function setUp()
    {
        self::bootKernel();
        $this->repository = static::$kernel->getContainer()->get('apiv1.repository.ticket');
    }

    /**
     * Checks entity retrieval by it's id.
     */
    public function testGetById()
    {
        $ticket = $this->repository->getById(1);
        $this->assertEquals(1, $ticket->getId());
    }

    /**
     * Checks entity retrieval by it's id.
     */
    public function testGetByIdReturnNull()
    {
        $ticket = $this->repository->getById(6);
        $this->assertEquals(null, $ticket);
    }

    /**
     * Checks transaction committing.
     */
    public function testCommitTransaction()
    {
        $entityManagerMock = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $entityManagerMock
            ->expects($this->once())
            ->method('flush')
            ->withAnyParameters();

        $entityMetadataMock = $this->getMockBuilder('Doctrine\ORM\Mapping\ClassMetadata')
            ->disableOriginalConstructor()
            ->getMock();

        /** @var EntityManager $entityManagerMock */
        /** @var ClassMetadata $entityMetadataMock */
        $repository = new TicketRepository($entityManagerMock, $entityMetadataMock);
        $repository->commitTransaction();
    }
}
