<?php

namespace ApiV1Bundle\Service\Resource;

use ApiV1Bundle\Exception\InvalidFormException;
use ApiV1Bundle\Form\TicketType;
use ApiV1Bundle\Model\Ticket\TicketInterface;
use ApiV1Bundle\Model\Ticket\TicketRepositoryInterface;
use ApiV1Bundle\Model\Ticket\TicketResourceInterface;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Service encapsulating additional business logic related with resource.
 */
class TicketResource implements TicketResourceInterface
{
    /** @var TicketResourceInterface */
    protected $repository;

    /** @var FormFactoryInterface */
    private $formFactory;

    /**
     * Injects dependencies.
     *
     * @param TicketRepositoryInterface $repository
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(TicketRepositoryInterface $repository, FormFactoryInterface $formFactory)
    {
        $this->repository = $repository;
        $this->formFactory = $formFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $parameters)
    {
        $ticket = $this->repository->create();

        return $this->processForm($ticket, $parameters, 'POST');
    }

    /**
     * Processes the form.
     *
     * @param TicketInterface $ticket
     * @param array $parameters
     * @param String $method
     * @return TicketInterface
     *
     * @throws InvalidFormException
     */
    private function processForm(TicketInterface $ticket, array $parameters, $method = 'PUT')
    {
        $form = $this->formFactory->create(new TicketType(), $ticket, ['method' => $method]);
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {
            $ticket = $form->getData();
            $this->repository->save($ticket);

            return $ticket;
        }

        throw new InvalidFormException('Invalid submitted data', $form);
    }

    /**
     * {@inheritdoc}
     */
    public function save(TicketInterface $entity)
    {
        $this->repository->save($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(TicketInterface $entity)
    {
        $this->repository->delete($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id)
    {
        return $this->repository->getById($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getByTitle($title)
    {
        return $this->repository->getByTitle($title);
    }
}
