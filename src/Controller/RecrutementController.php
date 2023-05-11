<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Form\RecrutementType;
use App\Entity\Recrutement;
use App\Repository\RecrutementRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class RecrutementController extends AbstractController






{
    #[Route('/recrutement', name: 'app_recrutement')]
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $form = $this->createForm(RecrutementType::class);

        // Traitement du formulaire soumis
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération des données du formulaire
            $recrutement = $form->getData();

            // Enregistrement dans la base de données

            $entityManager->persist($recrutement);
            $entityManager->flush();

            // Envoi d'un email à l'administrateur
            $email = (new Email())
                ->from('noreply@votresite.com')
                ->to('florian.catusse@epsi.fr')
                ->subject('Nouvelle candidature reçue')
                ->html('Une nouvelle candidature a été reçue.');

            $mailer->send($email);

            // Message flash
            $this->addFlash('success', 'Votre candidature a bien été envoyée.');

            // Redirection vers la page de confirmation
            return $this->redirectToRoute('app_recrutement');
        }

        // Affichage de la page de formulaire
        return $this->render('recrutement/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    //     #[Route('/recrutement', name: 'app_recrutement')]
    //     public function index(): Response
    //     {

    //         $form = $this->createForm(RecrutementType::class);
    //         return $this->render('recrutement/index.html.twig', [
    //             'form' => $form->createView(),
    //         ]);
    //     }

    //     public function store(request $request, EntityManagerInterface $entityManagerInterface): Response
    // {
    //     $recrutement = new recrutement();
    //     $form = $this->createForm(RecrutementType::class, $recrutement);
    //     $form->handleRequest($request); 
    //     if ($form->isSubmitted() && $form->isValid()) { //si le formulaire est soumis et valide
    //         $entityManager->persist($recrutement); //on demande à doctrine de persister la note
    //         $entityManager->flush(); //on demande à doctrine de flusher la note
    //         return $this->redirectToRoute('app_recrutement'); //on redirige vers la page note
    //     }
    //     return $this->render('home/index.html.twig', [
    //         'form' => $form->createView()
    //     ]);
    // }
    //     public function show(Request $request): Response
    //     {
    //         $recrutement = new Recrutement();
    //         $form = $this->createForm(recrutementType::class, $recrutement);
    //         $form->handleRequest($request);
    //         if ($form->isSubmitted() && $form->isValid()){
    //             dump($recrutement);die;
    //         }
    //         return $this->render('default/index.html.twig', [
    //             'form' => $form->createView()
    //         ]);
    //     }

}
