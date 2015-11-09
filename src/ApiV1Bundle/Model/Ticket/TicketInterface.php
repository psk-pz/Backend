<?php

namespace ApiV1Bundle\Model\Ticket;

/**
 * Entity's interface used to provide more flexible design.
 * Intentionally designed as an anemic domain model.
 */
interface TicketInterface
{
    /**
     * Gets entity's identifier.
     *
     * @return integer
     */
    public function getId();

    /**
     * Sets entity's title.
     *
     * @param string $title
     * @return TicketInterface
     */
    public function setTitle($title);

    /**
     * Gets entity's title.
     *
     * @return string
     */
    public function getTitle();
}
