<?php

namespace App\Controller;

use App\Repository\EquipementsRepository;
use App\Repository\ReservationsRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    #[Route('/home', name: 'app_home_complete')]
    public function index(ReservationsRepository $reservationsRepository, EquipementsRepository $equipementsRepository): Response
    {
        $allMessages = $this->getAvailableEquipments(['Carnon', 'Palavas-les-flots'], ['kayak simple', 'kayak double', "paddle"], $reservationsRepository,  $equipementsRepository);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'messages' => $allMessages,
        ]);
    }

    public function getAvailableEquipments($magasins, $types, ReservationsRepository $reservationsRepository, EquipementsRepository $equipementsRepository)
    {
        $messages = [];

        foreach ($magasins as $magasin) {
            $message = $magasin . ' : ';
            foreach ($types as $type) {
                $allOfType = $equipementsRepository->findBy(["modele" => $type, "magasin" => $magasin]);
                $allResa = $reservationsRepository->findBy(["date" => new DateTime(), "equipement" => $type]);
                $availableEquipments = [];
                foreach ($allOfType as $item) {
                    $isReserved = false;
                    foreach ($allResa as $resa) {
                        if ($resa->getEquipement()->getId() === $item->getId()) {
                            $isReserved = true;
                            break;
                        }
                    }
                    if (!$isReserved) {
                        $availableEquipments[] = $item;
                    }
                }
                $message .= count($availableEquipments) . ' ' . $type . ', ';
            }
            $message = rtrim($message, ', ');
            $messages[] = $message;
        }

        return $messages;
    }
}
