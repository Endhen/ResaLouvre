<?php 

namespace Louvre\ResaBundle\Services\ResaCleaner;

use Doctrine\ORM\EntityManagerInterface;

class Cleaner {
    private $em;
    private $bookingRep;
    
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
        $this->bookingRep = $this->em->getRepository('LouvreResaBundle:Booking');
    }
    
    public function clean($min) {
        
        $dateLimit = (new \DateTime)
            ->sub(new \DateInterval('P'.$min.'D'));
        
        $this->em
            ->createQuery('DELETE Louvre\ResaBundle\Entity\Booking b WHERE b.dateCreation > :dateLimit')
            ->setParameter('dateLimit', $dateLimit)
            ->execute();
    }
}