<?php

namespace ApiV1Bundle\Service\Resource;

use ApiV1Bundle\Model\TicketInterface;
use ApiV1Bundle\Model\TicketResourceInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Service encapsulating business logic related with ticket resource.
 */
class TicketResource implements TicketResourceInterface
{
    /** @var ObjectManager */
    private $om;

    /** @var TicketInterface */
    private $entity;

    /** @var ObjectRepository */
    private $repository;

    /**
     * Injects service's dependencies.
     *
     * @param ObjectManager   $om
     * @param TicketInterface $entityClass
     */
    public function __construct(ObjectManager $om, TicketInterface $entityClass)
    {
        $this->om = $om;
        $this->entity = $entityClass;
        $this->repository = $this->om->getRepository($this->entity);
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }
}
