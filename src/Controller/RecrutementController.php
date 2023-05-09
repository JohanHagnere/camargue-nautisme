<?php

namespace App\Controller;

use App\Repository\RecrutementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecrutementController extends AbstractController
{
    #[Route('/recrutement', name: 'app_recrutement')]
    public function index(RecrutementRepository $recrutementRepository): Response
    {$recrutement=$recrutementRepository->findAll();
        return $this->render('recrutement/index.html.twig', [
            'recrutement' => $recrutement,
        ]);
    }
}


