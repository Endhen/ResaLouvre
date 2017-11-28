<?php 

namespace Louvre\ResaBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HalfDayValidator extends ConstraintValidator 
{   
    public function validate ($boolean ,Constraint $constraint) 
    {
        $now = new \DateTime();
        
        $ticketDate = $this->context->getObject()->getTicketDate();
        
        if($boolean == true && (int) $now->format('H') > 14 && $now->format('Y/m/d') == $ticketDate->format('Y/m/d')) {
            $this
                ->context
                ->buildViolation($constraint->tooLate)
                ->setParameters(array('%date%' => 'le Mardi'))
                ->addViolation();
        }
        
    }
    
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}