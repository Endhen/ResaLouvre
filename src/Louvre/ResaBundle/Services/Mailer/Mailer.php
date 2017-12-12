<?php 

namespace Louvre\ResaBundle\Services\Mailer;

class Mailer 
{
    protected $mailer;
    protected $twig;
    
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig) {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }
    
    public function sendMail($data) 
    {
        $message = (new \Swift_Message('Email de confirmation'))
            ->setFrom('bogou.ncho@gmail.com')
            ->setTo($data['email'])
            ->setBody($this->renderTemplate($data));
        
        
        $this->mailer->send($message);
    }
    
    private function renderTemplate($data) {
        return $this->twig->render(
            //app/Resources/views/Email/confirmation.html.twig
            'email/confirmation.html.twig',
            $data, 
            'text/html'
        );
    }
}
