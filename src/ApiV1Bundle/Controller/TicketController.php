<?php

namespace ApiV1Bundle\Controller;

use ApiV1Bundle\Model\Ticket\TicketInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller used to handle requests sent to application.
 */
class TicketController extends FOSRestController
{
    /**
     * dsadsa
     *
     * @param Request               $request
     * @param ParamFetcherInterface $paramFetcher
     * @return \ApiV1Bundle\Entity\Ticket[]|array
     */
    public function getTicketsAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset', 0);
        $limit = $paramFetcher->get('limit');

        return $this->getDoctrine()->getManager()->getRepository('ApiV1Bundle:Ticket')->findBy([], null, $limit, $offset);
    }

    /**
     * Returns resource by it's identifier.
     *
     * @param integer $id
     * @return TicketInterface
     */
    public function getTicketAction($id)
    {
        return $this->get('apiv1.resource.ticket')->getById($id);
    }
}
