<?php

namespace App\Controller;

use App\Entity\Reservations;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ReservationsRepository;
use App\Form\ReservationFormType;
use Symfony\Component\HttpFoundation\Request;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation', methods: ["GET", "POST"])]
    public function index(Request $request, ReservationsRepository $reservationsRepository): Response
    {

        $reservation = new Reservations();
        $form = $this->createForm(ReservationFormType::class, $reservation);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $reservationsRepository->save($reservation, true);
            $this->addFlash('success', 'Votre réservation a bien été prise en compte !');
            return $this->redirectToRoute('app_reservation', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
            'form' => $form->createView(),
        ]);
    }
}
