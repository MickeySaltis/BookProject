<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\UserBook;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use App\Repository\StatusRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserBookFixtures extends Fixture
{
    public function __construct(private UserRepository $userRepository, private StatusRepository $statusRepository, private BookRepository $bookRepository)
    {}

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create(('fr_FR'));
        $users = $this->userRepository->findAll();
        $status = $this->statusRepository->findAll();
        $books = $this->bookRepository->findAll();

        /* Create 10 UserBook by User */
        foreach($users as $user) {
            for($i = 0; $i < 10; $i++) {
                $userBook = new UserBook();
                $userBook->setReader($user)
                        ->setStatus($faker->randomElement($status))
                        ->setRating($faker->numberBetween(0, 5))
                        ->setComment($faker->text())
                        ->setBook($faker->randomElement($books))
                        ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTime()))
                        ->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->dateTime()));
                $manager->persist($userBook);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array 
    {
        return [UserFixtures::class, StatusRepository::class, BookRepository::class];
    }
}
