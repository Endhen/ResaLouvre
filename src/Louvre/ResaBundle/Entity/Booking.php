<?php

namespace Louvre\ResaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Booking
 *
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="Louvre\ResaBundle\Repository\BookingRepository")
 */
class Booking
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
    * @ORM\Column(name="ticket_command", nullable=true)
    * @ORM\OneToOne(targetEntity="Louvre\ResaBundle\Entity\TicketCommand")
    */
    private $ticketCommand;
    
    /**
     * @var int
     *
     * @ORM\Column(name="nbTickets", type="integer")
     */
    private $nbTickets;


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
     * Set nbTickets
     *
     * @param integer $nbTickets
     *
     * @return Booking
     */
    public function setNbTickets($nbTickets)
    {
        $this->nbTickets = $nbTickets;

        return $this;
    }

    /**
     * Get nbTickets
     *
     * @return int
     */
    public function getNbTickets()
    {
        return $this->nbTickets;
    }

    /**
     * Set ticketCommand
     *
     * @param \Louvre\ResaBundle\Entity\TicketCommand $ticketCommand
     *
     * @return Booking
     */
    public function setTicketCommand(\Louvre\ResaBundle\Entity\TicketCommand $ticketCommand)
    {
        $this->ticketCommand = $ticketCommand->getId();

        return $this;
    }

    /**
     * Get ticketCommand
     *
     * @return @return \Louvre\ResaBundle\Entity\TicketCommand
     */
    public function getTicketCommand()
    {
        return $this->ticketCommand;
    }
}
