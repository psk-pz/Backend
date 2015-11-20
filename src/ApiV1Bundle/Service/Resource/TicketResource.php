<?php

namespace ApiV1Bundle\Service\Resource;

use ApiV1Bundle\Model\Ticket\TicketInterface;
use ApiV1Bundle\Model\Ticket\TicketRepositoryInterface;
use ApiV1Bundle\Model\Ticket\TicketResourceInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use ApiV1Bundle\Exception\InvalidResourceException;

/**
 * Service encapsulating additional business logic related with resource.
 */
class TicketResource implements TicketResourceInterface
{
    /** @var TicketResourceInterface */
    protected $repository;

    /** @var ValidatorInterface */
    private $validator;

    /**
     * Injects dependencies.
     *
     * @param TicketRepositoryInterface $repository
     * @param ValidatorInterface $validator
     */
    public function __construct(TicketRepositoryInterface $repository, ValidatorInterface $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $parameters)
    {
        $ticket = $this->repository->create();

        !isset($parameters['title']) ?: $ticket->setTitle($parameters['title']);
        !isset($parameters['content']) ?: $ticket->setContent($parameters['content']);

        $errors = $this->validator->validate($ticket);
        if (count($errors) > 0) {
            throw new InvalidResourceException($errors);
        }

        $this->repository->save($ticket);

        return $ticket;
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
