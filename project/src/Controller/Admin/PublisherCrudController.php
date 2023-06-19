<?php

namespace App\Controller\Admin;

use App\Entity\Publisher;
use App\Controller\Admin\Trait\ReadOnlyTrait;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PublisherCrudController extends AbstractCrudController
{
    use ReadOnlyTrait;
    
    public static function getEntityFqcn(): string
    {
        return Publisher::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name'),
            AssociationField::new('books')
                ->onlyOnIndex(),
            ArrayField::new('books')
                ->onlyOnDetail(),
        ];
    }
    
}
