<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CreateType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class LogController extends AbstractController
{
    #[Route('/create', name: 'app_create')]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(CreateType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('log/create.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(Request $request, UserPasswordEncoderInterface $passwordEncoder)
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
                if (!$passwordEncoder->isPasswordValid($user, $password)) {
                    $error = 'Email ou mot de passe incorrect.';
                } else {
                    // Authentification réussie - rediriger vers la page par défaut
                    return $this->redirectToRoute('app_default');
                }
            }

            $lastEmail = $email;
        }

        return $this->render('log/login.html.twig', [
            'last_email' => $lastEmail,
            'error' => $error,
        ]);
    }
}
