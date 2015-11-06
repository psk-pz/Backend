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
     * @Rest\View
     * @Rest\Get("/user/{id}.{_format}", requirements={"id" = "\d+"})
     *
     * @param integer $id Ticket's id
     * @return TicketInterface
     */
    public function getTicketAction($id)
    {
        return $this->get('api.ticket.resource')->get($id);
    }
}
