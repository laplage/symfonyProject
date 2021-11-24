<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        //création de l'instace de Faker
        $faker = Factory::create('FR-fr');


        //On instancie la classe annonce
        for ($i = 1; $i <= 30; $i++) {

            $title = $faker->sentence();
            $image = $faker->imageUrl(1000, 350);
            $introduction = $faker->paragraph();
            $content = $faker->paragraph();

            $ad = new Ad();
            $ad->setTitle($title)
                // ->setSlug("titre-d-l-annonce-n- $i")
                ->setCoverImage($image)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(mt_rand(50, 200))
                ->setRooms(mt_rand(1, 5));

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