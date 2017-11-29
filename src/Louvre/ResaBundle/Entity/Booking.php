<?php

namespace Louvre\ResaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
    * @ORM\OneToOne(targetEntity="Louvre\ResaBundle\Entity\TicketCommand", cascade={"remove"})
    */
    private $ticketCommand;
    
    /**
     * @var int
     *
     * @ORM\Column(name="nbTickets", type="integer")
     * @Assert\Range(
            min=1, 
            max=10, 
            minMessage="Vous ne pouvez pas resever moin d'un billet",
            maxMessage="Vous ne pouvez pas reservez plus de 10 tickets")
     */
    private $nbTickets;
    
    /**
    * var string
    *
    * @ORM\Column(name="code", type="string")
    */
    private $code;

    /**
    * @ORM\Column(name="charge", nullable=true)
    * @ORM\OneToOne(targetEntity="Louvre\ResaBundle\Entity\Charge", cascade={"remove"})
    */
    private $charge;
    
    
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

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Booking
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set charge
     *
     * @param string $charge
     *
     * @return Booking
     */
    public function setCharge($charge)
    {
        $this->charge = $charge;

        return $this;
    }

    /**
     * Get charge
     *
     * @return string
     */
    public function getCharge()
    {
        return $this->charge;
    }
}
