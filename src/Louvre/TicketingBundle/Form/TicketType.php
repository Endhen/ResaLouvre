<?php

namespace Louvre\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Type\TextType;
use Symfony\Component\Form\Extension\Type\DateType;
use Symfony\Component\Form\Extension\Type\CheckboxType;
use Symfony\Component\Form\Extension\Type\EntityType;

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
            ->add('email',        TextType::class)
            ->add('ticketDate',   DateType::class)
            ->add('reducedPrice', CheckboxType::class)
            ->add('day',          CheckboxType::class)
            ->add('tariffs',      EntityType::class, array(
                'class' => 'LouvreTicketingBundle:Tariff',
                'choice_label' => 'name',
                'multiple' => false,
                'expended' => false
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
