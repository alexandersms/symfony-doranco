<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class APIController extends AbstractController
{

    /**
     * Undocumented function
     * @Route("/api/meteo", name= "api_meteo")
     * @return JsonResponse
     */
    public function meteo(): JsonResponse
    {
        $today = [
            'temp' => 38,
            'unit' => 'celesius',
            'humidity' => '2%'
        ];
        return $this->json($today);
    }

    /**
     * Undocumented function
     * @Route("/meteo")
     * @return RedirectResponse
     */
    public function redictMeteo(): RedirectResponse
    {
        return $this->redirectToRoute('api_meteo');
    }

    /**
     * Undocumented function
     * @Route("/download/pdf", name= "download")
     * @return BinaryFileResponse
     */
    public function pdf(): BinaryFileResponse
    {
        $pdf = new File('documents/symfony-appli.pdf');   
        return $this->file($pdf, 'xander007.pdf', ResponseHeaderBag::DISPOSITION_INLINE);
    }

}

