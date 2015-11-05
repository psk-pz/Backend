<?php

namespace ApiBundle\Controller\V1;

use FOS\RestBundle\Controller\FOSRestController;

class TicketController extends FOSRestController
{
    public function getTicketAction($id)
    {
        return $this->getDoctrine()->getManager()->getRepository('ApiBundle:Ticket')->find($id);
    }
}
