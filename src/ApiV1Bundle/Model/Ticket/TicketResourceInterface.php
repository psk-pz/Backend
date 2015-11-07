<?php

namespace ApiV1Bundle\Model\Ticket;

/**
 * Interface for ticket resource.
 * Enables more flexible application design.
 */
interface TicketResourceInterface
{
    /**
     * Injects dependencies.
     *
     * @param TicketRepositoryInterface $repository
     */
    public function __construct(TicketRepositoryInterface $repository);

    /**
     * Gets ticket by it's id.
     *
     * @param integer $id
     * @return TicketInterface
     */
    public function get($id);
}
