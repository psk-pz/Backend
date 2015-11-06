<?php

namespace ApiBundle\Controller\V1;

use ApiBundle\Model\TicketInterface;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Description.
 */
class TicketController extends FOSRestController
{
    /**
     * Description.
     *
     * @param integer $id
     * @return TicketInterface
     */
    public function getTicketAction($id)
    {
        return $this->get('api.ticket.resource')->get($id);
    }
}
