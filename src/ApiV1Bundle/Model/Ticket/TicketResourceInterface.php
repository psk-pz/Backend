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
     * @return TicketInterface
     */
    public function create();

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
     * @return TicketInterface
     */
    public function getById($id);
}
