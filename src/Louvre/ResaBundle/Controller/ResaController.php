<?php

namespace Louvre\ResaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Louvre\ResaBundle\Entity\Booking;
use Louvre\ResaBundle\Entity\TicketCommand;
use Louvre\ResaBundle\Entity\Ticket;
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
            $em->getRepository('LouvreResaBundle:Booking')->deleteUnfinished();
            $em->persist($booking);
            $em->flush();
            
            $booking = $em->getRepository('LouvreResaBundle:Booking')->lastBooking();
            
            return $this->redirectToRoute('louvre_resa_command', array(
                'id' => $booking->getId()
            ));
        }
        
        return $this->render('LouvreResaBundle::Acceuil.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /*
    * @ParamConverter("booking", option={"mapping":{"booking_id":"id"}})
    */
    public function CommandAction(Request $request, Booking $booking)
    {
        $ticketCommand = new TicketCommand();
        $ticket = new Ticket();
        $x = 0;
            
        while($x < $booking->getNbTickets()) {
            $ticketCommand->getTickets()->add($ticket);
            $x++;
        }
        
        $form = $this->get('form.factory')->create(TicketCommandType::class, $ticketCommand);
       
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            //On établit un prix pour chaques billet, pour pas le mettre directement dans l'entité ? 
            $this
                ->get('louvre_resa.bill_maker')
                ->getBill($ticketCommand);

            
            $em = $this->getDoctrine()->getManager();
            $em->persist($booking);
            $em->persist($ticketCommand);
            $em->flush();
            
            $this
                ->get('louvre_resa.idslinker')
                ->linkIds($booking);
            
            $this->container->get('session')->set('tCommand', $ticketCommand->getId());
            
            return $this->redirectToRoute('louvre_resa_payement', array(
                'id' => $booking->getId()
            ));
        }
        
        $nb = $booking->getNbTickets();
        return $this->render('LouvreResaBundle:form:command.html.twig', array(
            'form' => $form->createView(),
            'nbtickets' => $nb
        ));
    }
    
    /*
    * @ParamConverter("booking", option={"mapping":{"booking_id":"id"}})
    */
    public function payementAction(Request $request, Booking $booking) {
        
        $tCommandId = $this->container->get('session')->get('tCommand');
        $em = $this->getDoctrine()->getManager();
        $tickets = $em->getRepository('LouvreResaBundle:Ticket')->findByTicketCommand($tCommandId);
        
        $total = $this->get('louvre_resa.bill_maker')->getTotal($tickets);
        
        $code = crypt($booking->getId(), 'py');
        
        
        if($request->isMethod('POST')) {
            \Stripe\Stripe::setApiKey("sk_test_eTBOW8h25RzsOIll8oWY6w3Z");

            // Token is created using Checkout or Elements!
            // Get the payment token ID submitted by the form:
            $token = $_POST['stripeToken'];
            $total = $_POST['total'];
            
            // Charge the user's card:
            $charge = \Stripe\Charge::create(array(
              "amount" => $total,
              "currency" => "eur",
              "description" => "Example charge",
              "source" => $token,
            ));
            
            return $this->redirectToRoute('louvre_resa_booking');
        }
        
        
        $date = (new \DateTime())->format('d/m/Y');
        return $this->render('LouvreResaBundle:form:payement.html.twig', array(
            'tickets' => $tickets,
            'nCommand' => $booking->getId(),
            'total' => $total,
            'code' => $code,
            'date' => $date
        ));
    }
    
    public function testAction() {
        return $this->render('LouvreResaBundle:form:strip.html.twig');
    }
}








