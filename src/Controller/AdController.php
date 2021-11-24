<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Repository\AdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo): Response //précision du type de param (Type Hinting)
    {
        //Création d'un objet de type repository
        // $repo = $this->getDoctrine()->getRepository(Ad::class);

        //récupération de toutes les annonces via la méthode findAll() du repository
        $ads = $repo->findAll();

        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }
    /**
     * Cette méthode Permet d'afficher une seule annonace
     * via son slug
     * @Route("/ads/{slug}",name="ads_show")
     * @return Response
     */
    public function show($slug, AdRepository $repo): Response
    {
        $ad = $repo->findOneBySlug($slug);
        return $this->render('ad/show.html.twig', [
            'ad' => $ad
        ]);

        // new Response();
    }
}