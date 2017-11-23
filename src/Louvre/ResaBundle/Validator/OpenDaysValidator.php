<?php 

namespace Louvre\ResaBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Louvre\ResaBundle\Services\Avail\Avail;

class OpenDaysValidator extends ConstraintValidator 
{
    private $avail;
    
    public function __construct(Avail $avail) 
    {    
        $this->avail = $avail;
    }
    
    public function validate ($date ,Constraint $constraint) 
    {
        $now = new \DateTime();
        
        if($date->format('w') == '2') {
            $this
                ->context
                ->buildViolation($constraint->closedDay)
                ->setParameters(array('%date%' => 'le Mardi'))
                ->addViolation();
            
        } elseif(!$this->avail->isAvailable($date)) {
            $this
                ->context
                ->buildViolation($constraint->full)
                ->setParameters(array('%date%' => $date->format('d m Y')))
                ->addViolation();
        } elseif($date < $now) {
            $this
                ->context
                ->buildViolation($constraint->outdated)
                ->setParameters(array('%date%' => $date->format('d m Y')))
                ->addViolation();
            
        } elseif($date->format('d m') == '01 05') {
            $this
                ->context
                ->buildViolation($constraint->closedDay)
                ->setParameters(array('%date%' => 'le 1er Mai'))
                ->addViolation();
            
        } elseif($date->format('d m') == '01 11') {
            $this
                ->context
                ->buildViolation($constraint->closedDay)
                ->setParameters(array('%date%' => 'le 1er Novembre'))
                ->addViolation();
            
        } elseif($date->format('d m') == '25 12') {
            $this
                ->context
                ->buildViolation($constraint->closedDay)
                ->setParameters(array('%date%' => 'le jour de Noel'))
                ->addViolation();
        }
    }
}