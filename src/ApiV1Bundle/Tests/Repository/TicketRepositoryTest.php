<?php

namespace ApiV1Bundle\Tests\Controller;

use PHPUnit_Framework_TestCase;
use ApiV1Bundle\Repository\TicketRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Unit and integration tests covering repository.
 */
class TicketRepositoryTest extends PHPUnit_Framework_TestCase
{
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
