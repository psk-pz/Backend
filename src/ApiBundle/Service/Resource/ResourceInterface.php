<?php

namespace ApiBundle\Service\Resource;

use ApiBundle\Model\TicketInterface;

interface ResourceInterface
{
    /**
     * Get a ticket by it's id.
     *
     * @api
     * @param integer $id
     * @return TicketInterface
     */
    public function get($id);
}
