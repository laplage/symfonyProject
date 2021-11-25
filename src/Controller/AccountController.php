<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     */
    public function login(AuthenticationUtils $utils): Response
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        return $this->render('account/login.html.twig', [
            'username' => $username,
            'isError' => $error !== null
        ]);
    }
    /**
     * Cette méthode permet de se déconnecter
     * @Route("/logout",name="account_logout")
     * @return void
     */
    public function logout()
    {
        // cette fonction ne fait rien parce que c'est symfony qui gère la déconnexion
    }
    /**
     * Cetteméthode permet d'afficher le formulaire d'inscription
     * @Route("/register",name="account_register")
     * @return Response
     */
    public function register(Request $request, UserPasswordHasherInterface $encoder, EntityManagerInterface $em): Response
    {
        //création de l'objet de type User
        $user = new User();
        //création du formulaire d'inscription
        $form = $this->createForm(RegisterType::class, $user);
        //Nous demandons à l'objet $form qui lié à l'objet $user de gérer la requête
        $form->handleRequest($request);
        //Nous allons persisté les données en base mais il faut vérifier si le formulaire est valide 
        if ($form->isSubmitted() && $form->isValid()) {
            //Avant l'enregistrement de l'utilisateur dans la base, on doit crypter le pwd
            $pwd = $encoder->hashPassword($user, $user->getPwd());
            //On remodifie le mot de passe de l'user avec le mot de passe crypté
            $user->setPwd($pwd);
            //on persiste l'objet $user en base de données
            $em->persist($user);
            $em->flush();

            //Après l'enregistrement, on redirige vers la page de connexion
            return $this->redirectToRoute("account_login");
        }
        return $this->render('account/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * Cette méthode permet d'editer le profil d'un utilisateur
     * @Route("/account/profile",name="account_profile")
     * @return void
     */
    public function profile(Request $request, EntityManagerInterface $em)
    {
        //Nous besoins des données de l'utilisateur connecté
        $user = $this->getUser();
        //Création du formulaire 
        $form = $this->createForm(AccountType::class, $user);
        //On demande a symfony de lier le formulaire avec l'entité user
        $form->handleRequest($request);

        //Vérifier la soumission et la validation du formulaire
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($user);
            $em->flush();
        }

        return $this->render('account/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }
}