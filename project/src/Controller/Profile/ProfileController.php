<?php

namespace App\Controller\Profile;

use App\Entity\UserBook;
use App\Service\ProfileService;
use App\Service\GoogleBooksApiService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profile', name: 'app_profile_')]
class ProfileController extends AbstractController
{
    public function __construct(private readonly GoogleBooksApiService $googleBooksApiService, private readonly ProfileService $profileService)
    {}

    /* Index */
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('profile/profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }

    /* Search */
    #[Route('/search', name: 'search')]
    public function search(): Response
    {
        return $this->render('profile/profile/search.html.twig');
    }

    /* Search API */
    #[Route('/search/api', name: 'search_api', methods: ['POST'])]
    public function search_api(Request $request): Response
    {

        $search = $request->request->get('search');


        return $this->render('profile/profile/_api.html.twig', [
            'search' => $this->googleBooksApiService->search($search),
        ]);
    }

    /* Add Book */
    #[Route('/search/add/{id}', name: 'search_add', methods: ['GET'])]
    public function searchAdd(string $id): Response
    {
        $userBook = $this->profileService->addBookToProfile($this->getUser(), $id);

        return $this->redirectToRoute('app_profile_my_book', [
            'id'=>$userBook->getId()
        ]);
    }

    /* Get Book */
    #[Route('/my-books/{id}', name: 'my_book')]
    public function myBook(UserBook $userBook): Response
    {
        // dd($userBook);
        return $this->render('profile/profile/my_book.html.twig', [
            'userBook'=>$userBook
        ]);
    }
}
