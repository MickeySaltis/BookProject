<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\User;
use App\Entity\Author;
use App\Entity\Status;
use App\Entity\UserBook;
use App\Entity\Publisher;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    /**
     * One-piece fixtures
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        /* Create of 10 Authors */
        $authors = [];

        for ($i = 0; $i < 10; $i++)
        {
            $author = new Author();
            $author->setName($faker->name());
            $manager->persist($author);

            $authors[] = $author;
        }

        /* Create of 10 Publishers */
        $publishers = [];

        for ($i = 0; $i < 10; $i++) {
            $publisher = new Publisher();
            $publisher->setName($faker->name());
            $manager->persist($publisher);

            $publishers[] = $publisher;
        }

        /* Create Status */
        $status = [];

        foreach(['à lire', 'en cours', 'lu'] as $value)
        {
            $oneStatus = new Status();
            $oneStatus->setName($value);
            $manager->persist($oneStatus);
            
            $status[] = $oneStatus;
        }

        /* Create of 100 Books */
        $books = [];

        for ($i = 0; $i < 100; $i++) {
            $book = new Book();
            $book
                ->setGoogleBooksId($faker->uuid())
                ->setTitle($faker->sentence())
                ->setSubtitle($faker->sentence())
                ->setPublishDate($faker->dateTime())
                ->setDescription($faker->text())
                ->setIsbn10($faker->isbn10())
                ->setIsbn13($faker->isbn13())
                ->setPageCount($faker->numberBetween(100, 500))
                ->setSmallThumbnail($faker->imageUrl(100, 150))
                ->setThumbnail($faker->imageUrl(200, 300))
                ->addAuthor($faker->randomElement($authors))
                ->addPublisher($faker->randomElement($publishers))
            ;
            $manager->persist($book);

            $books[] = $book;
        }

        /* Create of 10 Users */
        $users = [];

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user
                ->setEmail($faker->email())
                ->setPassword($this->hasher->hashPassword($user, 'password'))
                ->setPseudo($faker->userName())
            ;
            $manager->persist($user);

            $users[] = $user;
        }

        /* Create 10 UserBook by User */
        foreach ($users as $user)
        {
            for($i = 0; $i < 10; $i++)
            {
                $userBook = new UserBook();
                $userBook
                    ->setReader($user)
                    ->setStatus($faker->randomElement($status))
                    ->setRating($faker->numberBetween(0, 5))
                    ->setComment($faker->text())
                    ->setBook($faker->randomElement($books))
                    ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTime()))
                    ->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->dateTime()))
                ;
                $manager->persist($userBook);
            }
        }

        $manager->flush();
    }
}
