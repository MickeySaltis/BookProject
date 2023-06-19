<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Publisher;
use App\Entity\Status;
use App\Entity\User;
use App\Entity\UserBook;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(BookCrudController::class)->generateUrl());

       
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Project');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Livres', 'fa fa-book', Book::class);
        yield MenuItem::linkToCrud('Auteurs', 'fa fa-user-pen', Author::class);
        yield MenuItem::linkToCrud('Editeurs', 'fa fa-building', Publisher::class);
        yield MenuItem::linkToCrud('Status', 'fa fa-info-circle', Status::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-users', User::class);
        yield MenuItem::linkToCrud('Lectures', 'fa fa-book-reader', UserBook::class);
    }
}
