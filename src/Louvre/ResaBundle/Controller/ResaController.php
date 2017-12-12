<?php

namespace Louvre\ResaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Louvre\ResaBundle\Entity\Booking;
use Louvre\ResaBundle\Entity\TicketCommand;
use Louvre\ResaBundle\Entity\Ticket;
use Louvre\ResaBundle\Entity\Charge;
use Louvre\ResaBundle\Form\BookingType;
use Louvre\ResaBundle\Form\TicketCommandType;


class ResaController extends Controller
{
    public function BookingAction(Request $request)
    {
        $booking = new Booking();
        
        //Création du formulaire
        $form = $this->get('form.factory')->create(BookingType::class, $booking);
        
        //Si le formulaire est renvoyé
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            //On stocke le nombre de tickets voulu dans la session
            $session = $this->container->get('session');
            $session->set('nbTickets', $booking->getNbTickets());
            
            return $this->redirectToRoute('louvre_resa_command');
        }
        
        //afficher l'erreur de nombre
        return $this->render('LouvreResaBundle::Acceuil.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function CommandAction(Request $request)
    {
        // Définition des variables
        $session = $this->container->get('session');
        $nbTickets = $session->get('nbTickets');
        $ticketCommand = new ticketCommand();
        $x = 0;
        
        //On créer un ticketCommand contenant le nombre voulu de tickets
        if($nbTickets === null) {
            $nbTickets = 1;
        } 
        
        while($x < $nbTickets) {
            $ticket = new ticket();
            $ticketCommand->addTicket($ticket);
            $x++;
        }
        
        //On créer le formulaire de ticketCommand
        $form = $this->get('form.factory')->create(TicketCommandType::class, $ticketCommand);
        
        //var_dump($ticketCommand);exit;
        
        //Supprime les réservations non-finies de plus 20 minutes
        $this->get('louvre_resa.cleaner')->clean(20);
        
        //Si le formulaire est renvoyé
        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            //On établit un prix pour chaques billet
            $this
                ->get('louvre_resa.bill_maker')
                ->getBill($ticketCommand);
            
            //On créer la réservasion qui va être flush
            $booking = (new Booking())
                ->setNbTickets($nbTickets)
                ->setTicketCommand($ticketCommand);
            
            //var_dump($ticketCommand->getTickets());exit;
            
            //On enregistre
            $em = $this->getDoctrine()->getManager();
            $em->persist($booking);
            $em->flush();
            
            //on garde l'email pour la prochaine page
            $session->set('email', $ticketCommand->getEmail());
            
            return $this->redirectToRoute('louvre_resa_payement', array(
                'code' => $booking->getCode()
            ));
        }
        
        return $this->render('LouvreResaBundle:form:command.html.twig', array(
            'form' => $form->createView(),
            'nbtickets' => $nbTickets
        ));
    }
    
    /*
    * @ParamConverter("booking", option={"mapping":{"booking_code":"code"}})
    */
    public function payementAction(Request $request, Booking $booking) {
        
        // Définition des variables
        $em = $this->getDoctrine()->getManager();
        
        //On récupère les tickets de la commande en cour
        $tickets = $em
            ->getRepository('LouvreResaBundle:Ticket')
            ->findByTicketCommand($booking->getTicketCommand()->getId());
        
        $total = $this->get('louvre_resa.bill_maker')->getTotal($tickets);
        
        // Si le payement Stripe est effectué
        if($request->isMethod('POST')) {
            \Stripe\Stripe::setApiKey("sk_test_eTBOW8h25RzsOIll8oWY6w3Z");

            // On récupère le token et le prix total
            $token = $_POST['stripeToken'];
            
            // Charge the user's card:
            $stripeCharge = \Stripe\Charge::create(array(
              "amount" => $total*100,
              "currency" => "eur",
              "description" => "Example charge",
              "source" => $token,
            ));
            
            // Si le montant a été payé
            if($stripeCharge->paid ){
                //on enregistre la trace du payelent dans la bdd
                $charge = (new Charge())
                    ->setChargeId($stripeCharge->id)
                    ->setAmount($total)
                    ->setDescription("Test")
                    ->setSource($token);
                
                // On lie le payment a la réservation
                $booking->setCharge($charge);
                
                $em->persist($booking);
                $em->flush();
                
                $this->container->get('session')->set('total', $total);
                
                // Et on envoie la confirmation
                return $this->redirectToRoute('louvre_resa_confirmation', array(
                    'code' => $booking->getCode()
                ));
            } else {
                $error = 'Le payement n\'a pas pu s\'effecuer, veuillez reessayer';
            }
            
            return $this->render('LouvreResaBundle:form:payement.html.twig', array(
                'error' => $error,
                'tickets' => $tickets,
                'total' => $total/100,
                'code' => $booking->getCode(),
                'date' => $booking->getDateCreation()->format('d/m/Y')
            ));
        }
        
        
        return $this->render('LouvreResaBundle:form:payement.html.twig', array(
            'error' => null,
            'tickets' => $tickets,
            'total' => $total,
            'code' => $booking->getCode(),
            'date' => $booking->getDateCreation()->format('d/m/Y')
        ));
    }
    
    /*
    * @ParamConverter("booking", option={"mapping":{"booking_code":"code"}})
    */
    public function confirmationAction(Booking $booking) {
        
        // Définition des variables
        $session = $this->container->get('session');
        $email = $session->get('email');
        $total = $session->get('total');
        $em = $this->getDoctrine()->getManager();
        
        $tickets = $em
            ->getRepository('LouvreResaBundle:Ticket')
            ->findByTicketCommand($booking->getTicketCommand()->getId());
        
        // On envoi l'email de confimation avec toutes les donées requises
        $this->get('louvre_resa.mailer')->sendMail(array(
            'email' => $email,
            'tickets' => $tickets,
            'total' => $total/100,
            'code' => $booking->getCode(),
            'date' => $booking->getDateCreation()->format('d/m/Y')
        ));
        
        /* Test Email
        return $this->render('LouvreResaBundle::email.html.twig', array(
            'email' => $email,
            'tickets' => $tickets,
            'total' => $total/100,
            'code' => $booking->getCode(),
            'date' => $booking->getDateCreation()->format('d/m/Y')
        ));*/
        
        return $this->render('LouvreResaBundle::confirmation.html.twig', array(
            'email' => $email,
            'action' => 'enregistré',
            'message' => 'un récapitulatif de votre commande a été envoyé a votre adresse email : '
        ));
    }
    
    
    /*
    public function cancelAction($code) {
        \Stripe\Stripe::setApiKey("sk_test_eTBOW8h25RzsOIll8oWY6w3Z");
        
        $em = $this->getDoctrine()->getManager();
        $booking = $em->getRepository('LouvreResaBundle:Booking')->findByCode($code)[0];
        
        $chargeId = $booking->getCharge()->getChargeId();
        
        $re = \Stripe\Refund::create(array(
          "charge" => $chargeId
        ));
        
        //refund ? then
        
        return $this->render('LouvreResaBundle::confirmation.html.twig', array(
            'email' => 'truc',
            'action' => 'annulé',
            'message' => 'Vous pouvez recommancer une réservation  en retournant a la page d\'acceuil'
        ));
    }*/
}








