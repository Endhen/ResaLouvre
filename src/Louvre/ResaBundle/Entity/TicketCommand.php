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
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email( message="l'email {{ value }} n'est pas valide", checkMX=true)
     */
    private $email;
    
    /**
    * @ORM\OneToMany(targetEntity="Louvre\ResaBundle\Entity\Ticket", mappedBy="ticketCommand", cascade={"all"})
    * @Assert\Valid()
    */
    private $tickets;
    
    
    /**
    * @ORM\OneToOne(targetEntity="Louvre\ResaBundle\Entity\Booking", inversedBy="ticketCommand")
    * @ORM\JoinColumn(name="booking_id", referencedColumnName="id", onDelete="cascade")
    */
    private $booking;
    
    /**
    * var \Datetime
    *
    * @ORM\Column(name="date_creation", type="datetime")
    */
    private $dateCreation;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateCreation = new \DateTime();
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
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return TicketCommand
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return TicketCommand
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set booking
     *
     * @param \Louvre\ResaBundle\Entity\Booking $booking
     *
     * @return TicketCommand
     */
    public function setBooking(\Louvre\ResaBundle\Entity\Booking $booking = null)
    {
        $this->booking = $booking;

        return $this;
    }

    /**
     * Get booking
     *
     * @return \Louvre\ResaBundle\Entity\Booking
     */
    public function getBooking()
    {
        return $this->booking;
    }
}
