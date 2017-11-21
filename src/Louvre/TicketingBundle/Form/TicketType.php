<?php

namespace Louvre\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Louvre\TicketingBundle\Form\TariffType;

class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',    TextType::class)
            ->add('lastName',     TextType::class)
            ->add('email',        EmailType::class)
            ->add('ticketDate',   DateType::class)
            ->add('reducedPrice', CheckboxType::class)
            ->add('day',          CheckboxType::class)
            ->add('tariffs',      EntityType::class, array(
                'class' => 'LouvreTicketingBundle:Tariff',
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Louvre\TicketingBundle\Entity\Ticket'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'louvre_ticketingbundle_ticket';
    }


}
