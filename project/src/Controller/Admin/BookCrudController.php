<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Controller\Admin\Trait\ReadOnlyTrait;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BookCrudController extends AbstractCrudController
{
    use ReadOnlyTrait;

    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('googleBooksId'),
            TextField::new('title'),
            TextField::new('subtitle'),
            TextField::new('description'),
            TextField::new('isbn10'),
            TextField::new('isbn13'),
            ImageField::new('smallThumbnail'),
            ImageField::new('thumbnail'),
            CollectionField::new('authors'),
            CollectionField::new('publishers'),
        ];
    }
    
}
