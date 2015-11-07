<?php

namespace ApiV1Bundle\Model\Ticket;

use ApiV1Bundle\Model\Ticket\TicketInterface;

/**
 * Interface for ticket repository.
 * Enables more flexible application design.
 */
interface TicketRepositoryInterface
{
    /**
     * Retrieves ticket it's id.
     *
     * @param integer $id
     * @return TicketInterface | null
     */
    public function getById($id);
}
