<?php

namespace App\Controller\Admin;

use App\Entity\UserBook;
use App\Controller\Admin\Trait\ReadOnlyTrait;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class UserBookCrudController extends AbstractCrudController
{
    use ReadOnlyTrait;
    
    public static function getEntityFqcn(): string
    {
        return UserBook::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('reader'),
            TextField::new('book'),
            TextField::new('status'),
            IntegerField::new('rating'),
            TextareaField::new('comment'),
        ];
    }
    
}
