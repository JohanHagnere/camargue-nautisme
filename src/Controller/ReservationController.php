<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Entity\Reservations;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ReservationsRepository;
use App\Form\ReservationFormType;
use App\Repository\ClientsRepository;
use App\Repository\EquipementsRepository;
use Symfony\Component\HttpFoundation\Request;

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
            $dataMail = $form->get('mail')->getData();
            $dataNom = $form->get('nom')->getData();
            $dataPrenom = $form->get('prenom')->getData();
            $dataPhone = $form->get('telephone')->getData();
            $client = new Clients;
            $client->setMail($dataMail)->setNom($dataNom)->setPrenom($dataPrenom)->setTelephone($dataPhone);
            // Recup le client déjà en base
            $existingClient = $clientsRepository->findOneByMail($dataMail);
            $finalClient = null;
            if ($existingClient) {
                $finalClient = $existingClient;
                // utilisateur existe, donc passer son id à la résa
                // $idToFind = $existingClient->getId();
            } else {
                // créer un nouvel utilisateur et passer son id à la résa
                $clientsRepository->save($client, true);
                $finalClient = $client;
                // $idToFind = $client->getId();
            }
            $finalClient;
            // dataequipement c'est le modele dequipement sélectionné
            $allItems = $equipementsRepository->findBy(["modele" => $dataEquipement]);
            $allResa = $reservationsRepository->findBy(["date" => $dataDate]);
            dump($allItems);
            dump($dataDate);
            dump($allResa);
            // on récupère le client, le modele, on récupère la liste de résa, on compare si le client à sélectionné une date qui est déjà contenu dans la table résa, si c'est le cas, il faut ensuite récupérer la liste des kayak du meme type, on boucle sur la liste des id equipement pour vérifier si ils sont dans les résa à cette date 




            // $reservationsRepository->save($reservation, true);
            // $this->addFlash('success', 'Votre réservation a bien été prise en compte !');
            // return $this->redirectToRoute('app_reservation', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
            'form' => $form->createView(),
        ]);
    }
}
