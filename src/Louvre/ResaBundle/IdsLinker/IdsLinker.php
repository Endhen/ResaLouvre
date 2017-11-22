<?php 

namespace Louvre\ResaBundle\IdsLinker;

use Doctrine\ORM\EntityManagerInterface;
use Louvre\ResaBundle\Entity\Booking;

class IdsLinker {
    
    private $em;
    private $booking;
    private $ticketCommand;
    private $tickets;
    
    public function __construct (EntityManagerInterface $em) 
    {
        $this->em = $em;
        
        $this->ticketCommand = $em->getRepository('LouvreResaBundle:TicketCommand')->lastTicketCommand();
        $this->tickets = $em->getRepository('LouvreResaBundle:Ticket')->lastTickets();
    }
    
    public function setBooking(Booking $booking) {
        $this->booking = $booking;
        return $this;
    }
    
    public function linkIds() 
    {
        foreach ($this->tickets as $ticket) {
            $this->ticketCommand->addTicket($ticket);
            $this->em->persist($ticket);
        }
        
        /*var_dump($this->ticketCommand);
        exit;*/
        
        $this->booking->setTicketCommand($this->ticketCommand);
        
        $this->em->persist($this->booking);
        $this->em->persist($this->ticketCommand);
        
        $this->em->flush();
    }
}







