<?php

namespace ApiV1Bundle\Controller;

use ApiV1Bundle\Model\Ticket\TicketInterface;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Controller used to handle requests sent to application.
 */
class TicketController extends FOSRestController
{
    /**
     * Returns ticket by it's identifier
     *
     * @ApiDoc()
     *
     * @param integer $id
     * @return TicketInterface
     */
    public function getTicketAction($id)
    {
        return $this->get('apiv1.resource.ticket')->getById($id);
    }
}
