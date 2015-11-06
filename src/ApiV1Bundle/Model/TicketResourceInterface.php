<?php

namespace ApiV1Bundle\Model;

/**
 * Interface for ticket resource.
 * Enables more flexible application design.
 */
interface TicketResourceInterface
{
    /**
     * Gets ticket by it's id.
     *
     * @param integer $id
     * @return TicketInterface
     */
    public function get($id);
}
