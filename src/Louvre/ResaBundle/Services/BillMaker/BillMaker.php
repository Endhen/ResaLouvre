<?php 

namespace Louvre\ResaBundle\Services\BillMaker;

class BillMaker {
    
    public function getBill($ticketCommand) {
        $bill = 0;
        
        foreach($ticketCommand->getTickets() as $ticket) {
            $ticket->setPrice($this->getPrice($ticket));
        }
    }
    
    public function getPrice($ticket) 
    {    
        $now = new \DateTime('Y');
        $birthday = $ticket->getBirthday();
        $age = $now->diff($birthday)->y;
        
        if($age < 4) {
            return 0;
        } elseif($age <= 12) {
            return 8;
        } elseif($age < 60) {
            if($ticket->getReducedPrice()) {
                return 10;
            }
            return 16;
        } else {
            if($ticket->getReducedPrice()) {
                return 10;
            }
            return 12;
        }  
    }
    
    public function getTotal($tickets) {
        $total = 0;
        
        foreach($tickets as $ticket) {
            
            $total =+ $ticket->getPrice();
        }

        return $total;  
    }

}













