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
    /** @var EntityManager */
    private $entityManager;

    /** @var ClassMetadata */
    private $classMetadata;

    /** @var TicketRepository */
    private $repository;

    /**
     * Prepares repository instance for executing tests.
     */
    public function setUp()
    {
        self::bootKernel();

        $container = static::$kernel->getContainer();
        $entityName = $container->getParameter('apiv1.entity.ticket.class');

        $this->entityManager = $container->get('doctrine')->getManager();
        $this->classMetadata = new ClassMetadata($entityName);
        $this->repository = new TicketRepository($this->entityManager, $this->classMetadata);
    }

    /**
     * Checks creation of new entity instance.
     */
    public function testCreate()
    {
        $ticket = $this->repository->create();
        $this->assertInstanceOf($this->classMetadata->getName(), $ticket);
    }

    /**
     * Checks persisting new entity instance.
     */
    public function testSave()
    {
        $createdTicket = $this->repository->create();
        $createdTicket->setTitle('repository');
        $this->repository->save($createdTicket);

        $retrievedTicket = $this->repository->getByTitle('repository');

        $this->assertEquals($createdTicket->getId(), $retrievedTicket->getId());
    }

    /**
     * Checks purging entity from data store.
     *
     * @depends testSave
     */
    public function testDelete()
    {
        $ticket = $this->repository->getByTitle('repository');
        $this->repository->delete($ticket);

        $this->assertNull($this->repository->getByTitle('repository'));
    }

    /**
     * Checks retrieval of entity by it's id.
     */
    public function testGetById()
    {
        $ticket = $this->repository->getById(1);
        $this->assertEquals(1, $ticket->getId());
    }

    /**
     * Checks retrieval of nonexistent entity by it's id.
     *
     * @depends testDelete
     */
    public function testGetNonExistentById()
    {
        $ticket = $this->repository->getById(6);
        $this->assertNull($ticket);
    }

    /**
     * Checks retrieval of entity by it's title.
     */
    public function testGetByTitle()
    {
        $ticket = $this->repository->getByTitle('ticket1');
        $this->assertEquals('ticket1', $ticket->getTitle());
    }

    /**
     * Checks retrieval of nonexistent entity by it's title.
     */
    public function testGetNonExistentByTitle()
    {
        $ticket = $this->repository->getByTitle('ticket6');
        $this->assertNull($ticket);
    }

    /**
     * Checks transaction committing.
     */
    public function testCommitTransaction()
    {
        $ticket1 = $this->repository->create();
        $ticket2 = $this->repository->create();

        $ticket1->setTitle('transaction1');
        $ticket2->setTitle('transaction2');

        $this->repository->save($ticket1, false);
        $this->repository->save($ticket2, false);

        $this->assertEmpty(
            array_filter(
                [
                    $this->repository->getByTitle('transaction1'),
                    $this->repository->getByTitle('transaction2')
                ]
            )
        );

        $this->repository->commitTransaction();

        $retrievedTicket1 = $this->repository->getByTitle('transaction1');
        $retrievedTicket2 = $this->repository->getByTitle('transaction2');

        $this->assertEquals('transaction1', $retrievedTicket1->getTitle());
        $this->assertEquals('transaction2', $retrievedTicket2->getTitle());

        $this->repository->delete($retrievedTicket1, false);
        $this->repository->delete($retrievedTicket2, false);

        $deletedTicket1 = $this->repository->getByTitle('transaction1');
        $deletedTicket2 = $this->repository->getByTitle('transaction2');

        $this->assertEquals('transaction1', $deletedTicket1->getTitle());
        $this->assertEquals('transaction2', $deletedTicket2->getTitle());

        $this->repository->commitTransaction();

        $this->assertEmpty(
            array_filter(
                [
                    $this->repository->getByTitle('transaction1'),
                    $this->repository->getByTitle('transaction2')
                ]
            )
        );
    }
}
