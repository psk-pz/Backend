<?php

namespace ApiV1Bundle\Tests\Controller;

use ReflectionObject;
use ApiV1Bundle\Entity\Ticket;
use PHPUnit_Framework_TestCase;

/**
 * Unit tests covering entity.
 */
class TicketTest extends PHPUnit_Framework_TestCase
{
    /** @var Ticket */
    private $ticket;

    /**
     * Creates new instance of entity object, which will be shared between tests.
     */
    public function setUp()
    {
        $this->ticket = new Ticket();
    }

    /**
     * Checks getter for id field.
     */
    public function testId()
    {
        $reflectionObject = new ReflectionObject($this->ticket);
        $reflectionProperty = $reflectionObject->getProperty('id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($this->ticket, 1);

        $this->assertEquals(1, $this->ticket->getId());
    }

    /**
     * Checks setter and getter for title field.
     */
    public function testTitle()
    {
        $this->ticket->setTitle('ticket1');
        $this->assertEquals('ticket1', $this->ticket->getTitle());
    }

    /**
     * Checks setter and getter for content field.
     */
    public function testContent()
    {
        $this->ticket->setContent('ticket1');
        $this->assertEquals('ticket1', $this->ticket->getContent());
    }
}
