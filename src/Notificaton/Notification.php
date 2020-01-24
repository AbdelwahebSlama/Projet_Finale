<?php


namespace App\Notificaton;


use App\Entity\Contact;
use App\Entity\Message;
use Twig\Environment;

class Notification
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $render;

    public function __construct(\Swift_Mailer $mailer, Environment $render)
    {
        $this->mailer = $mailer;
        $this->render = $render;
    }

    public function contact(Message $contact)
    {

        $message = (new \Swift_Message('Agence: ' . $contact->getProperty()->getEmail()))
            ->setFrom('abdelwahebslama123@gmail.com')
            ->setTo('abdelwahebslama123@gmail.fr')
            ->setBody($this->render->render('emails/contactEmail.html.twig', [
                "contact" => $contact
            ]), 'text/html');

        $this->mailer->send($message);

    }


}