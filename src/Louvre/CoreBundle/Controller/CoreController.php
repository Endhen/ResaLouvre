<?php

namespace Louvre\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function indexAction()
    {
        return $this->render('LouvreCoreBundle::index.html.twig');
    }
}
