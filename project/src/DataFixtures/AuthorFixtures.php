<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Author;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create(('fr_FR'));

        /* Generate 10 Authors */
        for($i = 0; $i < 10; $i++)
        {
            $author = new Author();
            $author->setName($faker->name());
            $manager->persist($author);
        }

        $manager->flush();
    }
}