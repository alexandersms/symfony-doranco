<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TagController extends AbstractController
{
    /**
     * @Route("/tag", name="tag")
     * @return Response
     */
    public function index(): Response
    {

        $repository = $this->getDoctrine()->getRepository(Tag::class);

        $tag = $repository->findAll();
        return $this->render('tag/index.html.twig', [
            'tag' => $tag,
        ]);
    }

    /**
     * @Route("/tag/creation", name="tag_creation")
     * @return Response
     */
    public function create(Request $request): Response
    {
        $tag = new Tag();
        $formTag = $this->createForm(TagType::class, $tag);

        $formTag->handleRequest($request);

        if ($formTag->isSubmitted() && $formTag->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($tag);
            $manager->flush();

            $this->addFlash("info", "le tag a bien été enregistrer");

            return $this->redirectToRoute("tag");
        }

        return $this->render('tag/create.html.twig', [
            'formTag' => $formTag->createView()
        ]);
    }


    /**
     * Affiche le tag à modifier
     *
     * @Route("/tag/modification/{id<[0-9]+>}", name="update_tag")
     * @param Response $request
     * @param Tag $tag
     * @return Response
     */
    public function update(Request $request, Tag $tag): Response
    {
        $updateTag = $this->createForm(TagType::class, $tag);  
        $updateTag->handleRequest($request); 

        if ($updateTag->isSubmitted() && $updateTag->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($tag);
            $manager->flush();

            $this->addFlash("info", "le tag a bien été modifier");

            return $this->redirectToRoute("tag");
        }

        return $this->render('tag/update.html.twig', [
            'updateTag' => $updateTag->createView()
        ]);
    }

    /**
     * Suppression d'un produit
     * @Route("/tag/suppression/{id<[0-9]+>}", name="delete_tag", methods={"GET", "POST"})
     * @param Tag $product
     * @return Response
     */
    public function delete(Tag $tag): Response
    {
        // On sauvegarde le produit en BDD grâce au manager
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($tag);
        $manager->flush();

        // Ajout d'un message flash
        $this->addFlash('warnig', 'Le tag est supprimé');

        return $this->redirectToRoute('tag');
    }

}
