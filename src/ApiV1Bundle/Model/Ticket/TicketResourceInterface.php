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
     * @param TicketInterface $prototype
     * @param TicketRepositoryInterface $repository
     */
    public function __construct(TicketInterface $prototype, TicketRepositoryInterface $repository);

    /**
     * Creates new resource by cloning prototype.
     *
     * @return TicketInterface
     */
    public function createNew();

    /**
     * Gets ticket by it's id.
     *
     * @param integer $id
     * @return TicketInterface
     */
    public function get($id);
}
