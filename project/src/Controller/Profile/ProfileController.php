<?php

namespace App\Controller\Profile;

use App\Service\GoogleBooksApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile', name: 'app_profile_')]
class ProfileController extends AbstractController
{
    public function __construct(private readonly GoogleBooksApiService $googleBooksApiService)
    {}

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('profile/profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    #[Route('/search', name: 'search')]
    public function search(): Response
    {
        return $this->render('profile/profile/search.html.twig');
    }

    #[Route('/search/api', name: 'search_api', methods: ['POST'])]
    public function search_api(Request $request): Response
    {

        $search = $request->request->get('search');


        return $this->render('profile/profile/_api.html.twig', [
            'search' => $this->googleBooksApiService->search($search),
        ]);
    }
}
