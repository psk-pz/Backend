<?php

namespace ApiBundle\Model;

interface TicketInterface
{
    /**
     * Set title
     *
     * @param string $title
     * @return TicketInterface
     */
    public function setTitle($title);

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle();
}
