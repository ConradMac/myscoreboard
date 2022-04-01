<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use App\Form\GameType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;


class GameController extends AbstractController
{
    #[Route('/admin/game', name: 'app_admin_game')]
    public function index( GameRepository $gameRepository ): Response
    {
        /* On ne peut pas instancier d'objets d'une classe Repository,
        on doit les passer dans les arguments d'une méthode d'un contrôleur
        NB : pour chaque classe Entity créée, il y a une classe Repository qui correspond
        et qui permet de faire des requêtes SELECT sur la table correspondante */
        // $gameRepository = new GameRepository;
        return $this->render('admin/game/index.html.twig', [
            'games' => $gameRepository->findAll()
        ]);
    }

    // La classe Request permet d'instancier un objet qui contient toutes les valeurs des variables super-gloables de PHP.
    // Ces valeurs sont dans des propriétés (qui sont des objets)
    // $request->query contient $_GET
    // $request->request contient $_POST
    // $request->server contient $_SERVER
    // ...
    // Pour accéder aux valeurs, on utilisera sur ces propriétés la méthode->get('indice)

    /*
    * La classe EntityMangager va permettre d'exécuter les requêtes
    *  qui modifient les données (INSERT, UPDATE, DELETE).
    *  L'EntityManager va toujours utiliser des objets Entity pour 
    *  modifier les données. 
    */

    #[Route('/admin/game/new', name: 'app_admin_game_new')]
    public function new( Request $request, EntityManagerInterface $em )
    {
        // dd($request->request->get('game[title]'));

        $jeu = new Game;

        /* On crée un objet $form pour gérer le formulaire. Il est créé à partir de la classe GameType. On relie ce formulaire à l'objet de jeu */
        $form = $this->createForm( GameType::class, $jeu );

        /* L'objet form va gérer ce qui vient de la requête HTTP (avec l'objet $request) */
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() )
        {
            // dd($jeu);
            // dump($jeu);
            // La méthode persist prépare la requête INSERT avec les données de l'objet passé en argument
            $em->persist( $jeu );

            // La méthode flush() exécute les requêtes en attente et donc modifie les base de données
            $em->flush();

            return $this->redirectToRoute("app_admin_game");
        }
        return $this->render("admin/game/form.html.twig", [ "formGame" => $form->createView() ]);
    }

    #[Route('/admin/game/edit/{id}', name: 'app_admin_game_edit')]
    public function edit( Request $rq, $id, GameRepository $gameRepository, EntityManagerInterface $em )
    {
        // dd($id);
        $jeu = $gameRepository->find( $id );
        $form = $this->createForm( GameType::class, $jeu );
        $form->handleRequest($rq);

        if( $form->isSubmitted() && $form->isValid() )
        {
            $em->flush();
            return $this->redirectToRoute("app_admin_game");
        }

        return $this->render("admin/game/form.html.twig", [ "formGame" => $form->createView() ]);
    }


    #[Route('/admin/game/modifier/{title}', name: 'app_admin_game_modifier')]
    public function modifier( Request $rq, EntityManagerInterface $em, Game $jeu )
    {
        // dd($id);
        // $jeu = $gameRepository->find( $id );
        $form = $this->createForm( GameType::class, $jeu );
        $form->handleRequest($rq);

        if( $form->isSubmitted() && $form->isValid() )
        {
            $em->flush();
            return $this->redirectToRoute("app_admin_game");
        }

        return $this->render("admin/game/form.html.twig", [ "formGame" => $form->createView() ]);
    }
    
    /**
     * Exercice :
     * 1. Créer une route app_admin_game_delete, qui prend l'id en paramètre
     * 2. Afficher les informations du jeu à supprimer avec une nouvelle vue
     *         Confirmation de suppression du jeu suivant :
     *              . titre
     *              . nb_min et nb_max joueurs
     */

    #[Route('/admin/game/delete/{id}', name: 'app_admin_game_delete')]
    public function delete( $id, GameRepository $gameRepository, Request $rq, EntityManagerInterface $em )
    {
        $jeu = $gameRepository->find( $id );

        if( $rq->isMethod("POST") )
        {
            $em->remove( $jeu );
            $em->flush();
            return $this->redirectToRoute("app_admin_game");
        }

        return $this->render("admin/game/delete.html.twig", [ "jeu" => $jeu ]);
    }

}
