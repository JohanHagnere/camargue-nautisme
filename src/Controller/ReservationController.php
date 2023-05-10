<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Entity\Reservations;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ReservationsRepository;
use App\Form\ReservationFormType;
use App\Repository\ClientsRepository;
use App\Repository\EquipementsRepository;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation', methods: ["GET", "POST"])]
    public function index(Request $request, ClientsRepository $clientsRepository, ReservationsRepository $reservationsRepository, EquipementsRepository $equipementsRepository): Response
    {
        $reservation = new Reservations();
        $form = $this->createForm(ReservationFormType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dataEquipement = $form->get('equipement')->getData();
            $dataDate = $form->get('date')->getData();
            $dataLocalisation = $form->get('localisation')->getData();
            $dataMail = $form->get('mail')->getData();
            $dataNom = $form->get('nom')->getData();
            $dataPrenom = $form->get('prenom')->getData();
            $dataPhone = $form->get('telephone')->getData();
            $client = new Clients;
            $client->setMail($dataMail)->setNom($dataNom)->setPrenom($dataPrenom)->setTelephone($dataPhone);


            $existingClient = $clientsRepository->findOneByMail($dataMail);
            $finalClient = null;
            if ($existingClient) {
                $finalClient = $existingClient;
            } else {
                $clientsRepository->save($client, true);
                $finalClient = $client;
            }

            $allItems = $equipementsRepository->findBy(["modele" => $dataEquipement, "magasin" => $dataLocalisation]);
            $allResa = $reservationsRepository->findBy(["date" => $dataDate, "equipement" => $allItems]);

            $availableEquipment = [];
            foreach ($allItems as $item) {
                $isReserved = false;
                foreach ($allResa as $resa) {
                    if ($resa->getEquipement()->getId() === $item->getId()) {
                        $isReserved = true;
                        break;
                    }
                }
                if (!$isReserved) {
                    $availableEquipment[] = $item;
                }
            }

            if (count($availableEquipment) > 0) {
                $reservation->setClient($finalClient)
                    ->setEquipement($availableEquipment[0])
                    ->setDate($dataDate);
                $reservationsRepository->save($reservation, true);
                return $this->redirectToRoute('app_reservation', ['success' => 'true'], Response::HTTP_FOUND);
            } else {
                return $this->redirectToRoute('app_reservation', ['success' => 'false'], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
            'form' => $form->createView(),
        ]);
    }
}
