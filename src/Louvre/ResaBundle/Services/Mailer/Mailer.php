<?php 

namespace Louvre\ResaBundle\Service\Mailer;

class Mailer 
{
    protected $mailer;
    protected $twig;
    
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig) {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }
    
    public function sendMail($message, $email) 
    {
        $message = (new \Swift_Message($message->getSubject(), $message->getContent()))
            ->setFrom($message->getSenderEmail())
            ->setTo($email)
            ->setBody($this->renderTemplate($message));
        
        $this->mailer->send($message);
            
        // Envoyer confirmation
    }
    
    private function renderTemplate($message) {
        return $this->twig->render(
            //app/Resources/views/Email/conatct.html.twig
            'Email/comfirmation.html.twig', 
            array(
                'ticketCommand' => $ticketCommand, 
                'total' => $total, 
                'date' => $date
            ), 
            'text/html'
        );
    }
}
