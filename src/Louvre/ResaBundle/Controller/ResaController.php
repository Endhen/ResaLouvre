<?php

namespace Louvre\ResaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
            $em->flush();
            
            $booking = $em->getRepository('LouvreResaBundle:Booking')->lastBooking();
            
            return $this->redirectToRoute('louvre_resa_command', array(
                'id' => $booking->getId()
            ));
        }
        
        return $this->render('LouvreResaBundle::booking.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /*
    * @ParamConverter("booking", option={"mapping":{"booking_id":"id"}})
    */
    public function CommandAction(Request $request, Booking $booking)
    {
        $ticketCommand = new TicketCommand();
        
        //Penser a la demi journée uniquement disponible après 14h
        $form = $this->get('form.factory')->create(TicketCommandType::class, $ticketCommand);
        
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $form->handleRequest($request);
            
            $this->get('louvre_resa.bill_maker')->getBill($ticketCommand);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($booking);
            $em->persist($ticketCommand);
            $em->flush();
            
            $this
                ->get('louvre_resa.idslinker')
                ->linkIds();
            
            return $this->redirectToRoute('louvre_resa_booking');
        }
        
        $nb = $booking->getNbTickets();
        return $this->render('LouvreResaBundle::Command.html.twig', array(
            'form' => $form->createView(),
            'nbtickets' => $nb
        ));
    }
    
    public function payementAction() {
        
    }
}
