<?php

namespace ApiV1Bundle\Tests\Controller;

use ApiV1Bundle\Service\Resource\TicketResource;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Integration tests covering service.
 */
class TicketResourceTest extends KernelTestCase
{
    /** @var TicketResource */
    private $resource;

    /** @var string */
    private $entityClassName;

    /**
     * Prepares service instance for executing tests.
     */
    public function setUp()
    {
        self::bootKernel();

        $container = static::$kernel->getContainer();
        $repository = $container->get('apiv1.repository.ticket');

        $this->resource = new TicketResource($repository);
        $this->entityClassName = $repository->getClassName();
    }

    /**
     * Checks creation of new entity instance.
     */
    public function testCreate()
    {
        $ticket = $this->resource->create();
        $this->assertInstanceOf($this->entityClassName, $ticket);
    }

    /**
     * Checks persisting new entity instance.
     */
    public function testSave()
    {
        $createdTicket = $this->resource->create();
        $createdTicket->setTitle('repository');
        $this->resource->save($createdTicket);

        $retrievedTicket = $this->resource->getByTitle('repository');

        $this->assertEquals($createdTicket->getId(), $retrievedTicket->getId());
    }

    /**
     * Checks purging entity from data store.
     *
     * @depends testSave
     */
    public function testDelete()
    {
        $ticket = $this->resource->getByTitle('repository');
        $this->resource->delete($ticket);

        $this->assertNull($this->resource->getByTitle('repository'));
    }

    /**
     * Checks retrieval of entity by it's id.
     */
    public function testGetById()
    {
        $ticket = $this->resource->getById(1);
        $this->assertEquals(1, $ticket->getId());
    }

    /**
     * Checks retrieval of nonexistent entity by it's id.
     *
     * @depends testDelete
     */
    public function testGetNonExistentById()
    {
        $ticket = $this->resource->getById(6);
        $this->assertNull($ticket);
    }

    /**
     * Checks retrieval of entity by it's title.
     */
    public function testGetByTitle()
    {
        $ticket = $this->resource->getByTitle('ticket1');
        $this->assertEquals('ticket1', $ticket->getTitle());
    }

    /**
     * Checks retrieval of nonexistent entity by it's title.
     */
    public function testGetNonExistentByTitle()
    {
        $ticket = $this->resource->getByTitle('ticket6');
        $this->assertNull($ticket);
    }
}
