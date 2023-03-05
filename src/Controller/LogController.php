<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CreateType;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class LogController extends AbstractController
{
    #[Route('/create', name: 'app_create')]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(CreateType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Crypter le mot de passe avant de l'affecter à l'utilisateur
            $password = $form->get('mdp')->getData();
            $encodedPassword = password_hash($password, PASSWORD_DEFAULT);
            $user->setMdp($encodedPassword);

            $userRepository->save($user, true);

            return $this->render('log/login.html.twig', [
                'last_email' => $user->getEmail(),
                'error' => 'compte crée avec succés'
            ]);
        }

        return $this->renderForm('log/create.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(Request $request)
    {
        $error = '';
        $lastEmail = '';

        if ($request->isMethod('POST')) {
            // Récupérer l'email et le mot de passe saisis par l'utilisateur
            $email = $request->request->get('_username');
            $password = $request->request->get('_password');

            // Récupérer l'utilisateur correspondant à l'email saisi
            $userRepository = $this->getDoctrine()->getRepository(User::class);
            $user = $userRepository->findOneBy(['email' => $email]);

            if (!$user) {
                $error = 'Email ou mot de passe incorrect.';
            } else {
                // Vérifier le mot de passe saisi
                if ($password !== $user->getMdp()) {
                    $error = 'Email ou mot de passe incorrect.';
                } else {
                    // Authentification réussie - rediriger vers la page par défaut
                    if ($user->isIsBlocked()) {
                        $session = $request->getSession()->set('user', $user);
                        return $this->redirectToRoute('app_blocked', [], Response::HTTP_SEE_OTHER);
                    } else {

                        $session = $request->getSession()->set('user', $user);


                        return $this->redirectToRoute('app_my_profile', [], Response::HTTP_SEE_OTHER);
                    }
                }
            }

            $lastEmail = $email;
        }

        return $this->render('log/login.html.twig', [
            'last_email' => $lastEmail,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(SessionInterface $session): Response
    {
        $session->invalidate();

        return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/profile', name: 'app_my_profile', methods: ['GET'])]
    public function showMyProfile(Request $request): Response
    {
        $user = $request->getSession()->get('user');
        if ($user->isIsBlocked() == false) {

            return $this->render('log/profile.html.twig', [
                'user1' => $user, 'user' => $user
            ]);
        } else {
            return $this->redirectToRoute('app_blocked', [], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/profile/{id}', name: 'app_profile_affich', methods: ['GET'])]
    public function showOtherProfile(User $user1, Request $request): Response
    {
        $user = $request->getSession()->get('user');
        if ($user) {
            if ($user->isIsBlocked() == false) {
                return $this->render('log/profile.html.twig', [
                    'user1' => $user1, 'user' => $user
                ]);
            } else {
                return $this->redirectToRoute('app_blocked', [], Response::HTTP_SEE_OTHER);
            }
        } else {
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/blocked', name: 'app_blocked', methods: ['GET'])]
    public function showBlocked(Request $request): Response
    {

        $user = $request->getSession()->get('user');
        return $this->render('log/blocked.html.twig', ['user' => $user]);
    }
}
