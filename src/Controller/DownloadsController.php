<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DownloadsController extends AbstractController
{
    /**
     * @Route("/downloads", name="downloads")
     */
    public function index()
    {
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/downloads/{application}", name="application_overview")
     */
    public function applicationOverview(string $application) {



        return $this->render('home/index.html.twig', [
            'title' => $application . ' Downloads'
        ]);
    }
}
