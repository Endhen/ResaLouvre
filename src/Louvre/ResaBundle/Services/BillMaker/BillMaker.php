<?php 

namespace Louvre\ResaBundle\Services\BillMaker;

class BillMaker {
    
    public function getBill($ticketCommand) {
        $bill = 0;
        
        foreach($ticketCommand as $ticket) {
            $bill += $this->setPrice($ticket);
        }
        
        return $bill;
    }
    
    public function setPrice($ticket) 
    {    
        $age = $now->format('Y') - $ticket->birthday->format('Y');
        
        var_dump($age);
        exit;
    }
}