<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * Cette fonction permet de dire bonjour
     * @Route("/hello/{prenom}/{age}",name="hello") //2- la route c'est-à-dire l'URL avec laquelle on accède 
     * à la fonction
     */
    public function hello($prenom = "anonyme", $age = 0) //1- Fonction publique
    {
        return new Response(' Bonjour Mr ou Mme ' . $prenom . 'Vous avez : ' . $age . ' ans'); //3- la réponse
    }
    /**
     * Cette fonction permet d'afficher la page Home (principale)
     * @Route("/",name="homepage")
     * @return void
     */
    public function home()
    {
        // return new Response("
        //     <html>
        //         <head>
        //             <title> Première Page </title>
        //         </head>
        //         <body>
        //             <p>Bonjour à tous, Bienvenue dans cette formation !</p>
        //         </body>
        //     <html>             
        //         ");
        $liste = array('DVD', 'ORDINATEUR', 'ROMANS', 'LIVRES', 'VETEMENTS');

        return $this->render(
            'home.html.twig',
            [
                'age' => 8,
                'prenom' => 'Mr Dupond',
                'liste' => $liste
            ]
        );
    }
}