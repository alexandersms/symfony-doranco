<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function index()
    {
        //return new Response("<h1>Bonjour</h1>");
        return $this->render('index.html.twig');
    }
}

