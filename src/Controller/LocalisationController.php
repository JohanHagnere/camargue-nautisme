<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocalisationController extends AbstractController
{
    #[Route('/localisation', name: 'app_localisation')]
    public function index(): Response
    {
        return $this->render('localisation/index.html.twig', []);
    }
}
