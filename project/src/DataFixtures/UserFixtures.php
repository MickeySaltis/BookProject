<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {}

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create(('fr_FR'));

        /* Generate 10 Users */
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email())
                ->setPassword($this->hasher->hashPassword($user, 'password'))
                ->setPseudo($faker->userName())
                ->setRoles(["ROLE_USER"]);
            $manager->persist($user);
        }

        /* Generate Admin */
        $user = new User();
        $user->setEmail('admin@admin.com')
            ->setPassword($this->hasher->hashPassword($user, 'password'))
            ->setPseudo('Admin')
            ->setRoles(["ROLE_USER", "ROLE_ADMIN"]);
        $manager->persist($user);

        $manager->flush();
    }
}
