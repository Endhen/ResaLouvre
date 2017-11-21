<?php

namespace Louvre\TicketingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Louvre\TicketingBundle\Form\BookingType;
use Louvre\TicketingBundle\Entity\Ticket;
use Louvre\TicketingBundle\Entity\Booking;

class TicketingController extends Controller
{
    public function registrationAction(Request $request)
    {
        $booking = new Booking();
        
        $form = $this->get('form.factory')->create(BookingType::class, $booking);
        
        if($request->isMethod('POST') && $form->isValid()) {
            $form->handleRequest($request);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();
            
            return $this->redirectToRoute('louvre_ticketing');
        }
        return $this->render('LouvreTicketingBundle::form.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
