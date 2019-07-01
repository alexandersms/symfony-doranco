<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    
    /**
     * Affiche la liste des utilisateurs
     * 
     * @Route("/admin/liste", name= "user_liste")
     *
     * @return Response
     */
    public function show(): Response
    {
        $repository = $this->getDoctrine()->getRepository(User::class);


        $utilisateur = $repository->findAll();
        return $this->render('admin/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
        
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    

}
