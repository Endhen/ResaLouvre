<?php

namespace Louvre\ResaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

use Louvre\ResaBundle\Entity\Ticket;

class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $now = (int) (new \DateTime)->format('Y');
        
        $builder
            ->add('firstName',      TextType::class)
            ->add('lastName',       TextType::class)
            ->add('country',        CountryType::class, array(
                'preferred_choices' => array('FR', 'GB', 'ES', 'IT', 'DE', 'BEL', 'CH')))
            ->add('ticketDate',     DateType::class, array(
                'years' => range( $now , $now + 3 )
            ))
            ->add('birthday',       BirthdayType::class)
            ->add('reducedPrice',   CheckboxType::class, array(
                'required' => false
            ))
            ->add('halfDay',            CheckboxType::class, array(
                'required' => false
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ticket::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'louvre_resabundle_ticket';
    }


}
