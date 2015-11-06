<?php

namespace ApiV1Bundle\Service\Resource;

use ApiV1Bundle\Model\TicketInterface;

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
