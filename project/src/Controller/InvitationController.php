<?php

namespace App\Controller;

use App\Entity\Invitation;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class InvitationController extends AbstractController
{
    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher, private readonly EntityManagerInterface $entityManager)
    {}

    #[Route('/invitation/{uuid}', name: 'app_invitation')]
    public function register(Invitation $invitation, Request $request): Response
    {
        /* Redirection si invitation déjà utilisé */
        if(!$invitation->getReader() == null)
        {
            return $this->redirectToRoute('admin');
        }

        $user = new User();
        $user->setEmail($invitation->getEmail());
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            /* Invitation set Reader */
            $invitation->setReader($user);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('admin');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
