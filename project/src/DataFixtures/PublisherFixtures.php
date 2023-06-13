<?php

namespace App\DataFixtures;

use App\Entity\Publisher;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PublisherFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create(('fr_FR'));

        /* Generate 10 Publishers */
        for ($i = 0; $i < 10; $i++) {
            $publisher = new Publisher();
            $publisher->setName($faker->name());
            $manager->persist($publisher);
        }

        $manager->flush();
    }
}
