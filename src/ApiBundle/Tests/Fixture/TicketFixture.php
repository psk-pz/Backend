<?php

namespace ApiBundle\Tests\Fixture;

use ApiBundle\Entity\Ticket;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TicketFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $ticket = new Ticket();
        $ticket->setTitle('ticket');
        $manager->persist($ticket);
        $manager->flush();
    }
}
