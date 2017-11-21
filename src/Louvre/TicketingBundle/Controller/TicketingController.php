<?php

namespace Louvre\TicketingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TicketingController extends Controller
{
    public function registrationAction()
    {
        return $this->render('LouvreTicketingBundle::registration.html.twig');
    }
}
