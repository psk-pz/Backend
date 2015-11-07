<?php

namespace ApiV1Bundle\Service\Resource;

use ApiV1Bundle\Model\Ticket\TicketResourceInterface;
use ApiV1Bundle\Model\Ticket\TicketRepositoryInterface;

/**
 * Service encapsulating business logic related with ticket resource.
 */
class TicketResource implements TicketResourceInterface
{
    /** @var TicketResourceInterface */
    private $repository;

    /**
     * {@inheritdoc}
     */
    public function __construct(TicketRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        return $this->repository->getById($id);
    }
}
