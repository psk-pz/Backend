<?php

namespace ApiV1Bundle\Controller;

use ApiV1Bundle\Exception\InvalidFormException;
use ApiV1Bundle\Model\Ticket\TicketInterface;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @param Request $request the request object
     *
     * @return FormTypeInterface
     */
    public function postTicketAction(Request $request)
    {
        try {
            $ticket = $this->container->get('apiv1.resource.ticket')->create(
                $request->request->all()
            );

            $routeOptions = [
                'id' => $ticket->getId(),
                '_format' => $request->get('_format')
            ];

            return $this->routeRedirectView('apiv1_get_ticket', $routeOptions, Response::HTTP_CREATED);
        } catch (InvalidFormException $exception) {
            return $exception->getForm();
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
