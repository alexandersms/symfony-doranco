<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Produit;

class ProductController extends AbstractController
{
    
    /**
     * Undocumented function
     * @Route("/produit", name= "liste_produit")
     * @return Response
     */
    public function liste(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Produit::class);

        $produits = $repository->findAll();

        return $this->render('product/listeprod.html.twig', [
            'produits' => $produits
        ]);
    }

    /**
     * Undocumented function
     * @Route("/produit/creation")
     * @return Response
     */
    public function create(Request $requestHTTP): Response
    {
        dump($requestHTTP->request);
        return $this->render('product/create.html.twig');
    }

    /**
     * Undocumented function
     * @Route("/produit/{slug}", name= "produit" , requirements={"slug"="[a-z0-9\-]+"}, methods={"GET", "POST"})
     * @return Response
     */
    public function show(string $slug): Response
    {
        return $this->render('product/show.html.twig', [
            'slug'=> $slug
        ]);
    }
   
}

