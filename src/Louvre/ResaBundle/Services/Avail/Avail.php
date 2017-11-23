<?php 

namespace Louvre\ResaBundle\Services\Avail;

use Doctrine\ORM\EntityManagerInterface;

class Avail {
    
    private $em;
    
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }
    
    public function isAvailable($date) {
        $rep = $this->em->getRepository('LouvreResaBundle:Ticket');
        
        if(count($rep->findBy(array('ticketDate' => $date)) < 1000)) {
            return true;
        }
    }
}