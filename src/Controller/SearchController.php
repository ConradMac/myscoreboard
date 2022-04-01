<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(Request $rq, GameRepository $gr): Response
    {
        $word = $rq->query->get("search"); 
        $jeu = $gr->findBySearch($word);
        // SELECT * FROM game WHERE title LIKE '% test %'
        return $this->render('search/index.html.twig', [ // on remplace search par home
            'jeux'         => $jeu,
            'word'  => $word,
            'nb_joueurs'   => 0 //dans le fichier home index, il y etait mais pas necessaire
        ]);
    }
}
