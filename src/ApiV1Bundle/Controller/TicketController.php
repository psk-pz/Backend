<?php

namespace ApiV1Bundle\Controller;

use ApiV1Bundle\Model\TicketInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Description.
 */
class TicketController extends FOSRestController
{
    /**
     * Description.
     *
     * @param integer $id Ticket's id
     * @return TicketInterface
     */
    public function getTicketAction($id)
    {
        return $this->get('apiv1.ticket.resource')->get($id);
    }
}
