<?php 

namespace Louvre\ResaBundle\Validator;

use Symfony\Component\Validator\Constraint;


/**
* @Annotation
*/
class HalfDay extends Constraint 
{
    public $tooLate = "Vous ne pouvez prendre des journée complètes le jour même qu'avant 14h00";
    
    public function validatedBy()
    {
        return 'louvre_resa_halfday';
    }
}