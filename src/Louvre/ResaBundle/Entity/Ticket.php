<?php

namespace Louvre\ResaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Louvre\ResaBundle\Validator\OpenDays;
use Louvre\ResaBundle\Validator\HalfDay;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="Louvre\ResaBundle\Repository\TicketRepository")
 */
class Ticket
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
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * @var \DateTime
     *
     * @OpenDays()
     *
     * @ORM\Column(name="ticketDate", type="datetime")
     */
    private $ticketDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="datetime")
     */
    private $birthday;

    /**
     * @var bool
     *
     * @ORM\Column(name="reducedPrice", type="boolean")
     */
    private $reducedPrice;

    /**
     * @var bool
     *
     * @ORM\Column(name="half_day", type="boolean")
     * @HalfDay()
     */
    private $halfDay;
    
    /**
    * @var integer
    * 
    * @ORM\Column(name="price", type="integer", nullable=true)
    */
    private $price;
    
    /**
    * @ORM\ManyToOne(targetEntity="Louvre\ResaBundle\Entity\TicketCommand", inversedBy="ticket")
    * @ORM\JoinColumn(name="ticketCommand_id", referencedColumnName="id", onDelete="cascade")
    */
    private $ticketCommand;
    
    /**
    * var \Datetime
    *
    * @ORM\Column(name="date_creation", type="datetime")
    */
    private $dateCreation;

    public function __construct() {
        $this->dateCreation = new \DateTime();
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Ticket
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Ticket
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Ticket
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set ticketDate
     *
     * @param \DateTime $ticketDate
     *
     * @return Ticket
     */
    public function setTicketDate($ticketDate)
    {
        $this->ticketDate = $ticketDate;

        return $this;
    }

    /**
     * Get ticketDate
     *
     * @return \DateTime
     */
    public function getTicketDate()
    {
        return $this->ticketDate;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return Ticket
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set reducedPrice
     *
     * @param boolean $reducedPrice
     *
     * @return Ticket
     */
    public function setReducedPrice($reducedPrice)
    {
        $this->reducedPrice = $reducedPrice;

        return $this;
    }

    /**
     * Get reducedPrice
     *
     * @return bool
     */
    public function getReducedPrice()
    {
        return $this->reducedPrice;
    }

    /**
     * Set halfDay
     *
     * @param boolean $halfDay
     *
     * @return Ticket
     */
    public function setHalfDay($halfDay)
    {
        $this->halfDay = $halfDay;

        return $this;
    }

    /**
     * Get halfDay
     *
     * @return bool
     */
    public function getHalfDay()
    {
        return $this->halfDay;
    }

    /**
     * Set ticketCommand
     *
     * @param \Louvre\ResaBundle\Entity\TicketCommand $ticketCommand
     *
     * @return Ticket
     */
    public function setTicketCommand(\Louvre\ResaBundle\Entity\TicketCommand $ticketCommand = null)
    {
        $this->ticketCommand = $ticketCommand;

        return $this;
    }

    /**
     * Get ticketCommand
     *
     * @return \Louvre\ResaBundle\Entity\TicketCommand
     */
    public function getTicketCommand()
    {
        return $this->ticketCommand;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Ticket
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Ticket
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
}
