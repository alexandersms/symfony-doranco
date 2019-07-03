<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\EditRoleUserType;

/**
 * class AdminController
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }


    /**
     * @Route("/users", name= "list_users")
     * @param UserRepository $repository
     * @return Response
     */
    public function listUser(UserRepository $repository): Response
    {
        return $this->render('admin/user/show.html.twig', [
            'users' => $repository->findAll()
        ]);
    }
    
    /**
     * Permet de modifier le role d'un utilisateur
     * 
     * @Route("/changerole/{id<[0-9]+>}", name= "change_role")
     *
     * @param Request $request
     * @param User $user
     * @param ObjectManager $manager
     * @return Response
     */
    public function changeRole(Request $request, User $user, ObjectManager $manager): Response
    {

        $formUser = $this->createForm(EditRoleUserType::class, $user);

      
        $formUser->handleRequest($request);

        
        if ($formUser->isSubmitted() && $formUser->isValid()) {
         
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            $this->addFlash('warning', 'Le role utilisateur a bien été modifié');

           
            return $this->redirectToRoute('list_users');
        }

        return $this->render('admin/user/update.html.twig', [
            'formUser' => $formUser->createView()
        ]);
    }
}
