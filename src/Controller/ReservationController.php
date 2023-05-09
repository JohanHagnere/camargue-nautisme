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
use Symfony\Component\HttpFoundation\Request;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation', methods: ["GET", "POST"])]
    public function index(Request $request, ClientsRepository $clientsRepository, ReservationsRepository $reservationsRepository): Response
    {

        $reservation = new Reservations();
        $form = $this->createForm(ReservationFormType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dataMail = $form->get('mail')->getData();
            $dataNom = $form->get('nom')->getData();
            $dataPrenom = $form->get('prenom')->getData();
            $dataPhone = $form->get('telephone')->getData();
            $client = new Clients;
            $client->setMail($dataMail)->setNom($dataNom)->setPrenom($dataPrenom)->setTelephone($dataPhone);
            // Recup le client déjà en base
            $existingClient = $clientsRepository->findOneByMail($dataMail);
            $idToFind = null;
            if ($existingClient) {
                $idToFind = $existingClient->getId();
                dump($idToFind);
                // utilisateur existe, donc passer son id à la résa
            } else {
                // créer un nouvel utilisateur et passer son id à la résa
                $clientsRepository->save($client, true);
                $idToFind = $client->getId();
                dump($idToFind);
            }

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
