<?php

namespace ApiV1Bundle\Service\Resource;

use ApiV1Bundle\Model\Ticket\TicketInterface;
use ApiV1Bundle\Model\Ticket\TicketResourceInterface;
use ApiV1Bundle\Model\Ticket\TicketRepositoryInterface;

/**
 * Service encapsulating business logic related with ticket resource.
 */
class TicketResource implements TicketResourceInterface
{
    /** @var TicketInterface */
    protected $prototype;

    /** @var TicketResourceInterface */
    protected $repository;

    /**
     * {@inheritdoc}
     */
    public function __construct(TicketInterface $prototype, TicketRepositoryInterface $repository)
    {
        $this->prototype = $prototype;
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function createNew()
    {
        return clone $this->prototype;
    }

    /**
     * {@inheritdoc}
     */
    public function save()
    {
        $this->repository->save();
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        return $this->repository->getById($id);
    }
}
