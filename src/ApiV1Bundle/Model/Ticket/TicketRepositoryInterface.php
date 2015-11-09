<?php

namespace ApiV1Bundle\Model\Ticket;

use ApiV1Bundle\Model\Ticket\TicketInterface;

/**
 * Interface for entity's repository.
 * Adheres to expert principle by managing entity's life cycle.
 */
interface TicketRepositoryInterface
{
    /**
     * Creates new instance of entity.
     * Lowers coupling between repository and entity.
     */
    public function create();

    /**
     * Persists entity into data store.
     * Queues in transaction if it is not automatically committed.
     *
     * @param TicketInterface $entity
     * @param boolean         $autoCommit
     */
    public function save(TicketInterface $entity, $autoCommit = true);

    /**
     * Purges entity from data store.
     * Queues in transaction if it is not automatically committed.
     *
     * @param TicketInterface $entity
     * @param boolean         $autoCommit
     */
    public function delete(TicketInterface $entity, $autoCommit = true);

    /**
     * Commits all write operations queued up in transaction.
     */
    public function commitTransaction();

    /**
     * Retrieves entity by it's id.
     *
     * @param integer $id
     * @return TicketInterface | null
     */
    public function getById($id);
}
