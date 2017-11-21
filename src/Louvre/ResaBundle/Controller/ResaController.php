<?php

namespace Louvre\ResaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Louvre\ResaBundle\Entity\Booking;
use Louvre\ResaBundle\Entity\TicketCommand;
use Louvre\ResaBundle\Form\BookingType;
use Louvre\ResaBundle\Form\TicketCommandType;

class ResaController extends Controller
{
    public function BookingAction(Request $request)
    {
        $booking = new Booking();
        
        $form = $this->get('form.factory')->create(BookingType::class, $booking);
        
        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($booking);
            $em->flush();//error
            
            return $this->redirectToRoute('louvre_resa_booking');
        }
        
        return $this->render('LouvreResaBundle::booking.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function CommandAction()
    {
        return $this->render('LouvreResaBundle::booking.html.twig');
    }
}
