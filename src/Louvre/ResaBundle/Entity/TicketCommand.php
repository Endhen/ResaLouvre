<?php

namespace Louvre\ResaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TicketCommand
 *
 * @ORM\Table(name="ticket_command")
 * @ORM\Entity(repositoryClass="Louvre\ResaBundle\Repository\TicketCommandRepository")
 */
class TicketCommand
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
    * @ORM\OneToMany(targetEntity="Louvre\ResaBundle\Entity\Ticket", mappedBy="TicketCommand", cascade={"persist", "remove"})
    * @Assert\Valid()
    */
    private $tickets;

    public function __constructor() {
        $this->tickets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tickets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ticket
     *
     * @param \Louvre\ResaBundle\Entity\Ticket $ticket
     *
     * @return TicketCommand
     */
    public function addTicket(\Louvre\ResaBundle\Entity\Ticket $ticket)
    {
        $ticket->setTicketCommand($this);
        
        $this->tickets[] = $ticket;

        return $this;
    }

    /**
     * Remove ticket
     *
     * @param \Louvre\ResaBundle\Entity\Ticket $ticket
     */
    public function removeTicket(\Louvre\ResaBundle\Entity\Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }
}
