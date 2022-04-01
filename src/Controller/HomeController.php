<?php

namespace App\Controller;

use App\Entity\Contest;
use App\Entity\Game;
use App\Form\CommencerPartieType;
use App\Repository\GameRepository;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name:'app_home')]
function index(GameRepository $gameRepository, PlayerRepository $pr): Response
    {
    return $this->render('home/index.html.twig', [
        "games"         => $gameRepository->findAll(),
        'nb_joueurs'    => count($pr->findAll()),
        'gagnants'       => $pr->FindWinners()
        
    ]);
}

#[Route("/commencer-une-partie-{title}", name:"app_home_contest")]
function commencer(Game $game, Request $request, EntityManagerInterface $em)
    {
    $partie = new Contest;
    $partie->setGame($game);
    $form = $this->createForm(CommencerPartieType::class, $partie);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($game);
        $em->flush();
        // $this->addFlash("success", "La nouvelle partie a bien été enregistrée"); 
            // addFlash(arg 1 type, arg2 messages)
        // $this->addFlash("success", "succès")
        // $this->addFlash("danger", "Message d'erreur")
        // $this->addFlash("info", "Message d'info")
        return $this->redirectToRoute('app_home');
    }

    return $this->render("home/commencer.hmtl.twig", [
        'form' => $form->createView(),
    ]
    );
}




}