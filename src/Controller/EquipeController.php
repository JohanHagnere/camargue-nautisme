<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EquipeRepository;
class EquipeController extends AbstractController
{
    #[Route('/equipe', name: 'app_equipe')]
       public function index(EquipeRepository $equipeRepository): Response
    { $equipe= $equipeRepository->findAll();
        return $this->render('equipe/index.html.twig', [
            'equipe' => $equipe,
        ]);
    }
}
