<?php

namespace ApiV1Bundle\Service\Resource;

use ApiV1Bundle\Model\Ticket\TicketInterface;
use ApiV1Bundle\Model\Ticket\TicketRepositoryInterface;
use ApiV1Bundle\Model\Ticket\TicketResourceInterface;

/**
 * Service encapsulating additional business logic related with resource.
 */
class TicketResource implements TicketResourceInterface
{
    /** @var TicketResourceInterface */
    protected $repository;

    /**
     * Injects dependencies.
     *
     * @param TicketRepositoryInterface $repository
     */
    public function __construct(TicketRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        return $this->repository->create();
    }

    /**
     * {@inheritdoc}
     */
    public function save(TicketInterface $entity)
    {
        $this->repository->save($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(TicketInterface $entity)
    {
        $this->repository->delete($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id)
    {
        return $this->repository->getById($id);
    }
}
