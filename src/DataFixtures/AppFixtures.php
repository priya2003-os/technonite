<?php

namespace App\DataFixtures;


use Faker\Factory;
use App\Entity\Artiste;
use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $categoryNames = ['Mélodique', 'Industrielle', 'Groovy', 'Deep', 'Détroit'];
        $concertIndex = 1;

        for ($i = 0; $i < 5; $i++) {
            $category = new Categorie();
            $category->setName($categoryNames[$i]);
            $manager->persist($category);

            for ($j = 0; $j < rand(3, 8); $j++) {
                $concert = rand(1, 5) <= 2 ? $concertIndex : 0;
                $artiste = new Artiste();
                $artiste->setNom( $faker->firstName())
                    ->setDescription($faker->text())
                    ->setCategori($category)
                    ->setConcert($concert);

                $manager->persist($artiste);
            }
        }

        $manager->flush();
    }

}
