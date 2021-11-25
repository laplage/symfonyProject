<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Entity\Image;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



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
     * Cette méthode permet de créer une annonce
     * @Route("/ads/new",name="ads_create")
     * @return Response
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $ad = new Ad();
        //création du formulaire via le FormBuilder
        // $form  = $this->createFormBuilder($ad)
        //     ->add('title', TextType::class, [
        //         'label' => 'Titre',
        //         'attr' =>
        //         ['placeholder' => 'Renseignez le titre de lannonce']
        //     ])
        //     ->add('introduction')
        //     ->add('content')
        //     ->add('rooms')
        //     ->add('price')
        //     ->add('coverImage')
        //     ->getForm(); //permet de créer réellement le formulaire

        //Comment créer notre formulaire à partir de AdType
        $form = $this->createForm(AdType::class, $ad);

        //comment récupérer les données dans l'objet request ?
        //prmière méthode
        // $title = $request->request->get('title');
        //deuxième méthode
        $form->handleRequest($request); // $ad->setTitle($request->request->get('title'))
        //comment persister les données en base ?   

        if ($form->isSubmitted() && $form->isValid()) {

            //comment récupérer les images
            // $images = $form->get('images')->getData();
            // //récupération des images une par une dans le tableau images

            // foreach ($images as $image) {
            //on génère un nouveau  nom de fihcier
            // $fichier = md5(uniqid()) . '.' . $image->guessExtension();

            //On copie l'image dans le dossier images 
            // $this->getParameter('images_directory')
            // $image->move('/public/images', $fichier);
            //ajout de l'image dans l'objet
            // $img = new Image();
            // $img->setUrl($fichier)
            //     ->setCaption($fichier);
            // $ad->addImage($img);
            // ->setAd($ad);
            // }
            //on persiste l'objet en base 
            $em->persist($ad);
            $em->flush();
            //Après l'enregistrement de l'annonce, on redirige vers la homepage
            return $this->redirectToRoute('ads_index');
        }
        //la réponse
        return $this->render('ad/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Cette méthode Permet d'afficher une seule annonace
     * via son slug
     * @Route("/ads/{slug}",name="ads_show")
     * @return Response
     */
    public function show(Ad $ad): Response //$slug, AdRepository $repo): Response
    {
        // $ad = $repo->findOneBySlug($slug);
        return $this->render('ad/show.html.twig', [
            'ad' => $ad
        ]);

        // new Response();
    }
}