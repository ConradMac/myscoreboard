<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test-route', name: 'app_test')]
    public function index(): Response
    {
        // $currentRoute = $request->attributes->get('_route');

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestControl',
            'texte' => 'Saluuuuut'
            // ,'route' => $currentRoute,
        ]);
    }

    // #[Route('/test-calcul', name: 'test-calcul')]
    // public function calcul( Request $request ) : Response
    // {
    //     $currentRoute = $request->attributes->get('_route');

    //     return $this->render('test/index.html.twig', [
    //         'controller_name' => 'TestController',
    //         'Resultat' => 12+7,
    //         'route' => $currentRoute,
    //     ]);
    // }

    // Route calcul
    #[Route('/test/calcul')]
    public function calcul() : Response
    {
        $a = 12;
        $b = 7;

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'texte' => 'Théo',
            'Resultat' => $a+$b
        ]);
    }

    /* EXERCICE

    Ajouter une route pour le chemin "/test/calcul"
    qui utilise le fichier test/index.html.twig
    et qui affiche le resultat de 12 + 7

    */
    // Route salut
    #[Route('/test/salut')]
    public function salut()
    {
        return $this->render('test/salut.html.twig', [
            'prenom' => 'Théo'
        ]);
    }

    // Route tableau
    #[Route('/test/tableau')]
    public function tableau()
    {
        $tableau = [ "bonjour", "Je m'appelle", 789, true ];
        return $this->render("test/tableau.html.twig", ["tableau" => $tableau] );
    }

    // Route tableau
    #[Route('/test/tableau-assoc')]
    public function tab()
    {
        $p = [
            "nom" => "Cérien",
            "prenom" => "Jean",
            "age" => "26"
        ];

        return $this->render("test/assoc.html.twig", ["personne" => $p] );
    }

    #[Route('/test/objet')]
    public function objet()
    {
        $objet = new \stdClass;
        $objet->prenom = "Nordine";
        $objet->nom = "Ateur";
        $objet->age = 40;

        return $this->render("test/assoc.html.twig", ["personne" => $objet] );
    }
}
