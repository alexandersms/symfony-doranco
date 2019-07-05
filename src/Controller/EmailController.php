<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
    /**
     * @Route("/email", name="email")
     */
    public function index(\Swift_Mailer $mailer)
    {
        $mail = new \Swift_Message();
        $mail->setSubject('hasta la vista');
        $mail->setFrom('mobutu@marechal.com');
        $mail->setTo('php.symfony77@gmail.com');
        $mail->setBody(
            $this->renderView('email/modal-mail.html.twig'), 'text/html'
        );
        $mailer->send($mail);

        return $this->render('email/index.html.twig', [
            'controller_name' => 'EmailController',
        ]);
    }
}
