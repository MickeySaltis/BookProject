<?php

namespace App\DataFixtures;

use Faker\Factory;

use App\Entity\Status;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class StatusFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create(('fr_FR'));

        /* Generate status */
        foreach (['à lire', 'en cours', 'lu'] as $value) {
            $status = new Status();
            $status->setName($value);
            $manager->persist($status);
        }

        $manager->flush();
    }
}
