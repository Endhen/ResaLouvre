<?php 

namespace Louvre\ResaBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class OpenDaysValidator extends ConstraintValidator 
{
    public function validate ($date ,Constraint $constraint) 
    {
        $now = new \DateTime();
        
        if($date->format('w') == '2') {
            $this
                ->context
                ->buildViolation($constraint->tuesday)
                ->setParameters(array('%date%' => 'le Mardi'))
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