<?php
namespace App\Controller;

use App\Entity\Produit;
//use App\Entity\Category;
//use Symfony\Component\HttpFoundation\Request;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

        $produits = $repository->findBy([
            'isPublished' => true
        ]);

        return $this->render('product/listeprod.html.twig', [
            'produits' => $produits
        ]);
    }


    /**
     * Undocumented function
     * @Route("/produit/gestion/creation")
     * @return Response
     */
    public function create(Request $requestHTTP, UserInterface $user, ObjectManager $manager): Response
    {
        //dump($requestHTTP->request);

        // Recuperation du formaulaire
        $produit = new Produit();
        $formProduit = $this->createForm(ProductType::class, $produit);

        // On envoit les données postées au formulaire
        $formProduit->handleRequest($requestHTTP);

        //On verifie que le formulaire est soumie et valide
        if ($formProduit->isSubmitted() && $formProduit->isValid()) {

            $produit->setUser($user);
            //$manager = $this->getDoctrine()->getManager();
            $manager->persist($produit);
            $manager->flush();

            //Ajout d'un message flash
            $this->addFlash("info", "le produit a bien été enregistrer");

            //Redirection
            return $this->redirectToRoute("liste_produit");
        }
        
        
        return $this->render('product/create.html.twig', [
            'formProduit' => $formProduit->createView()
        ]);
    }


    /**
     * Affiche et traite le formulaire de modification d'un produit
     * @Route("/produit/gestion/modification/{slug<[a-z0-9\-]+>}", name= "prod_update", methods={"GET", "POST"})
     * @param Request $requestHTTP
     * @param Product $product
     * @return Response
     */
    public function update(Request $requestHTTP, Produit $produit, ObjectManager $manager, UserInterface $user): Response
    {
        if ($produit->getUser() !== $user) {
            if (!$this->isGranted('ROLE_ADMIN')) {
                throw $this->createAccessDeniedException("L'utilisateur courant n'a pas publié ce produit");
            }
        }

        // Récupération du formulaire
        $formProduit = $this->createForm(ProductType::class, $produit);

        // On envoie les données postées au formulaire
        $formProduit->handleRequest($requestHTTP);

        // On vérifie que le formulaire est soumis et valide
        if ($formProduit->isSubmitted() && $formProduit->isValid()) {
            // On sauvegarde le produit en BDD grâce au manager
            //$manager = $this->getDoctrine()->getManager();
            $manager->flush();

            // Ajout d'un message flash
            $this->addFlash('warning', 'Le produit a bien été modifié');

            // Redirection
            return $this->redirectToRoute('liste_produit');
        }

        return $this->render('product/update.html.twig', [
            'formProduit' => $formProduit->createView()
        ]);
    }

    /**
     * Suppression d'un produit
     * @Route("/produit/suppression/{slug<[a-z0-9\-]+>}", name= "prod_delete", methods={"GET", "POST"})
     * @IsGranted("ROLE_MODERATEUR")
     * @param Product $product
     * @return Response
     */
    public function delete(Produit $produit): Response
    {
        // On sauvegarde le produit en BDD grâce au manager
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($produit);
        $manager->flush();

        // Ajout d'un message flash
        $this->addFlash('danger', 'Le produit est supprimé');

        return $this->redirectToRoute('liste_produit');
    }

    /**
     * Undocumented function
     * @Route("/produit/oldcreation")
     * @return Response
     */
    public function oldcreate(ObjectManager $manager)
    {
        //dump($requestHTTP->request);

        // Recuperation de la categorie
        /*
        $category = $this->getDoctrine()
                         ->getRepository(Category::class)
                         ->find(1)
                         ;
        for ($i=1; $i <= 6 ; $i++) { 
        $produit = new Produit();
        $produit->setName("Tablette Android $i")
                ->setDescription("Cette tablette 13 pouces Android fonctionne sous le système d'exploitation 5.1. Elle est équipée de composants de qualité et performant. Si vous cherchez une tablette tactile grand écran, que ce soit pour le travail ou une tablette familiale, alors ne cherchez plus, vous êtes au bon endroit. Cette tablette Octa Core, 2Go de RAM et 16Go de mémoire interne saura vous conquérir. Couleur : Noir.")
                ->setImageName('tablette-andro.jpg')
                ->setIsPublished(true)
                ->setPrice(mt_rand(90, 200))
                ->setCategories($category)
                ;

                $manager->persist($produit);
                $manager->flush();
        }
        return $this->render('product/create.html.twig');
        */
    }

    /**
     * Undocumented function
     * @Route("/produit/{slug}", name= "produit" , requirements={"slug"="[a-z0-9\-]+"}, methods={"GET", "POST"})
     * @return Response
     */
    public function show(string $slug): Response
    {
        // Recuperation du repository
        $repository = $this->getDoctrine()
                           ->getRepository(Produit::class);
        
        // Recuperation du produit lié au slug
        $produit = $repository->findOneBy([
            'slug' => $slug,
            'isPublished' => true
        ]);
        // si on a pas de produit -> page 404

        if (!$produit) {
            throw $this->createNotFoundException('Produit non trouvé');
        }

        return $this->render('product/show.html.twig', [
            'produit' => $produit
        ]);
    }
}
