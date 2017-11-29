<?php 

namespace Louvre\ResaBundle\Services\ResaCleaner;

use Doctrine\ORM\EntityManagerInterface;

class Cleaner {
    private $em;
    
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }
    
    public function clean(){
        
        $entity = array('Booking', 'TicketCommand', 'Ticket');
        
        foreach ($entity) {
            $this->em->getRepository('LouvreResaBundle:Booking')->;
        }
        
        
    }
}