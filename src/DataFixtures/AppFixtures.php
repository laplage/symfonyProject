<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        //création de l'instace de Faker
        $faker = Factory::create('FR-fr');
        //création des utilisateurs
        $users = []; // Tableau dans lequel nous stocké les utilisateurs
        //création du tableau pour les genres
        $genres = ['male', 'female'];
        for ($u = 1; $u <= 10; $u++) {
            $user = new User();
            //Le choix du genre de manière aléatoire dans le tableau des genres
            $genre = $faker->randomElement($genres);
            $picture = 'https://randomuser.me/api/portraits/'; //men/93.jpg
            $imgageId = $faker->numberBetween(1, 99) . '.jpg';
            //reconstitution de l'adresse (adresse complète de la photo)
            $picture = $picture . ($genre == 'male' ? 'men/' : 'women/') . $imgageId;
            //ecriture simplifiée
            // $picture .= ($genre == 'male' ? 'men/' : 'women/') . $imgageId;

            // on encode (crypte) le mot de passe du user
            $pwd = $this->encoder->encodePassword($user, 'Test1234');

            //On modifie l'état du user
            $user->setFirstName($faker->firstName($genre))
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setIntroduction($faker->sentence())
                ->setDescription($faker->paragraph())
                ->setPwd($pwd)
                ->setPicture($picture);
            //on persiste l'utilisateur en base
            $manager->persist($user);
            //on rajoute l'utilisateur dans le tableau des users
            $users[] = $user;
        }

        //On instancie la classe annonce
        for ($i = 1; $i <= 30; $i++) {

            $title = $faker->sentence();
            $image = $faker->imageUrl(1000, 350);
            $introduction = $faker->paragraph();
            $content = $faker->paragraph();

            $ad = new Ad();

            //La sélection de manière aléatoire d'un utilisateur dans le tableau des 10 users
            $user = $users[mt_rand(0, count($users) - 1)];

            $ad->setTitle($title)
                // ->setSlug("titre-d-l-annonce-n- $i")
                ->setCoverImage($image)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(mt_rand(50, 200))
                ->setRooms(mt_rand(1, 5))
                ->setAuthor($user);

            //création des images de l'annonce
            for ($j = 1; $j <= mt_rand(2, 5); $j++) {
                //création de l'objet Image
                $image = new Image();
                $image->setUrl($faker->imageUrl())
                    ->setCaption($faker->sentence())
                    ->setAd($ad);
                $manager->persist($image);
            }
            $manager->persist($ad);
        }
        $manager->flush();
    }
}