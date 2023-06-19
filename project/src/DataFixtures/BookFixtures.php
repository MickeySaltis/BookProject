<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\PublisherRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BookFixtures extends Fixture
{
    public function __construct(private AuthorRepository $authorRepository, private PublisherRepository $publisherRepository)
    {

    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create(('fr_FR'));
        $authors = $this->authorRepository->findAll();
        $publishers = $this->publisherRepository->findAll();

        /* Generate 100 Books */
        for ($i = 0; $i < 100; $i++) {
            $book = new Book();
            $book->setGoogleBooksId($faker->uuid())
                ->setTitle($faker->sentence())
                ->setSubtitle($faker->sentence())
                ->setPublishDate($faker->dateTime())
                ->setDescription($faker->text())
                ->setIsbn10($faker->isbn10())
                ->setIsbn13($faker->isbn13())
                ->setPageCount($faker->numberBetween(100, 500))
                ->setSmallThumbnail('https://picsum.photos/100/150')
                ->setThumbnail('https://picsum.photos/200/300')
                ->addAuthor($faker->randomElement($authors))
                ->addPublisher($faker->randomElement($publishers))
            ;
            $manager->persist($book);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [AuthorFixtures::class, PublisherFixtures::class];
    }
}
