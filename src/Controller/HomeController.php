<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function index():Response
    {
        //return new Response("<h1>Bonjour</h1>");
        return $this->render('index.html.twig');
    }

    /**
     * Undocumented function
     * @Route ("/contact", name= "contact")
     * @return void
     */
    public function contact()
    {
        return $this->render('contact.html.twig');
    }
}

