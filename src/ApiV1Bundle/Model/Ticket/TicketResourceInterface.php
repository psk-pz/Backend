<?php

namespace ApiV1Bundle\Model\Ticket;

/**
 * Interface for resource.
 * Adheres to indirection principle and makes controller more thin.
 */
interface TicketResourceInterface
{
    /**
     * Creates new resource.
     *
     * @param array $parameters
     *
     * @return TicketInterface
     */
    public function create(array $parameters);

    /**
     * Persists resource into data store.
     *
     * @param TicketInterface $entity
     */
    public function save(TicketInterface $entity);

    /**
     * Purges resource from data store.
     *
     * @param TicketInterface $entity
     */
    public function delete(TicketInterface $entity);

    /**
     * Retrieves resource by it's id.
     *
     * @param integer $id
     * @return TicketInterface | null
     */
    public function getById($id);

    /**
     * Retrieves resource by it's title.
     *
     * @param string $title
     * @return TicketInterface | null
     */
    public function getByTitle($title);
}
