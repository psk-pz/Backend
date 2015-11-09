<?php

namespace ApiV1Bundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Holds predefined data to insert.
 */
class TicketFixture extends AbstractFixture implements ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Inserts example tickets into database.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $repository = $this->container->get('apiv1.repository.ticket');

        $ticket1 = $repository->create();
        $ticket1->setTitle('ticket1');
        $this->setReference('ticket1', $ticket1);

        $ticket2 = $repository->create();
        $ticket2->setTitle('ticket2');
        $this->setReference('ticket2', $ticket2);

        $ticket3 = $repository->create();
        $ticket3->setTitle('ticket3');
        $this->setReference('ticket3', $ticket3);

        $ticket4 = $repository->create();
        $ticket4->setTitle('ticket4');
        $this->setReference('ticket4', $ticket4);

        $ticket5 = $repository->create();
        $ticket5->setTitle('ticket5');
        $this->setReference('ticket5', $ticket5);

        $repository->save($ticket1, false);
        $repository->save($ticket2, false);
        $repository->save($ticket3, false);
        $repository->save($ticket4, false);
        $repository->save($ticket5, false);
        $repository->commitTransaction();
    }
}
