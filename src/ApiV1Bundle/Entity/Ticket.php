<?php

namespace ApiV1Bundle\Entity;

use ApiV1Bundle\Model\Ticket\TicketInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Represents ticket entity.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ApiV1Bundle\Repository\TicketRepository")
 */
class Ticket implements TicketInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text")
     */
    private $title;


    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }
}
