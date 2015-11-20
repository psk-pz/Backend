<?php

namespace ApiV1Bundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use ApiV1Bundle\Model\Ticket\TicketInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormInterface;
use ApiV1Bundle\Exception\InvalidResourceException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Controller used to handle requests sent to application.
 */
class TicketController extends FOSRestController
{
    /**
     * Creates entity from submitted data
     *
     * @ApiDoc()
     *
     * @param Request $request
     * @return View | FormInterface
     */
    public function postTicketAction(Request $request)
    {
        try {
            $ticketResource = $this->container->get('apiv1.resource.ticket');
            $ticket = $ticketResource->create($request->request->all());

            return $this->routeRedirectView('apiv1_get_ticket', ['id' => $ticket->getId()], Response::HTTP_CREATED);
        } catch (InvalidResourceException $exception) {
            return $exception->getViolationList();
        }
    }

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
