<?php

namespace ApiV1Bundle\Model;

/**
 * Interface for ticket entity.
 * Enables more flexible application design.
 */
interface TicketInterface
{
    /**
     * Gets ticket's identifier.
     *
     * @return integer
     */
    public function getId();

    /**
     * Sets ticket's title.
     *
     * @param string $title
     * @return TicketInterface
     */
    public function setTitle($title);

    /**
     * Get's ticket title.
     *
     * @return string
     */
    public function getTitle();
}
