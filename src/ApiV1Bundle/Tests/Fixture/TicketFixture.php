<?php

namespace ApiV1Bundle\Tests\Fixture;

use ApiV1Bundle\Entity\Ticket;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Holds predefined data to insert.
 */
class TicketFixture implements FixtureInterface
{
    /**
     * Inserts example tickets into database.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $ticket = new Ticket();
        $ticket->setTitle('ticket');
        $manager->persist($ticket);
        $manager->flush();
    }
}
