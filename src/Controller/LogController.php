<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CreateType;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use App\Form\ResetPasswordFormType;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ResetPasswordRequestFormType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;


class LogController extends AbstractController
{
    #[Route('/create', name: 'app_create')]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $user->setIsBlocked(false);
        $form = $this->createForm(CreateType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Crypter le mot de passe avant de l'affecter à l'utilisateur
            $password = $form->get('mdp')->getData();

            $encodedPassword = password_hash($password, PASSWORD_DEFAULT);
            $user->setMdp($encodedPassword);
            $user->setResetToken("");

            $userRepository->save($user, true);

            return $this->redirectToRoute('app_login', [
                'last_email' => $user->getEmail(),
                'error' => 'compte crée avec succés', Response::HTTP_SEE_OTHER
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
            $encodedPasswordlog = password_hash($password, PASSWORD_DEFAULT);
            // Récupérer l'utilisateur correspondant à l'email saisi
            $userRepository = $this->getDoctrine()->getRepository(User::class);
            $user = $userRepository->findOneBy(['email' => $email]);
            

            if (!$user) {
                $error = 'user introuvable ! .';
            } else {
                $encodedPassword = $user->getMdp();
                // Vérifier le mot de passe saisi
                if (!password_verify($password, $encodedPassword)) {
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
                'user' => $user, 'user1' => $user,
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


    #[Route('/email', name: 'app_email', methods: ['GET'])]
    public function sendEmail(MailerInterface $mailer): Response
    {

        $email =  (new Email())
            // ...
            // simple contents defined as a string
            ->text('Lorem ipsum...');
        try {
            $mailer->send($email);
            return new Response("Mail was seeeeeeent");
        } catch (TransportExceptionInterface $e) {
            // some error prevented the email sending; display an
            // error message or try to resend the message
            dd("err");
            return new Response("Mail was sent");
        }
        // $email = (new Email())
        //     // email address as a simple string
        //     ->from('goacademy66@gmail.com')
        //     ->to('oussemaxbox360@gmail.com')
        //     ->subject('hello mail')
        //     ->text('blablabla');

        // email address as an object
        //->from(new Address('fabien@example.com'))

        // defining the email address and name as an object
        // (email clients will display the name)
        //->from(new Address('fabien@example.com', 'Fabien'))

        // defining the email address and name as a string
        // (the format must match: 'Name <email@example.com>')
        // ->from(Address::create('Fabien Potencier <fabien@example.com>'));

        return new Response("Mail was sent");

        // ...
    }

    #[Route('/oubli-pass', name: 'forgotten_password')]
    public function forgottenPassword(
        Request $request,
        UserRepository $usersRepository,
        TokenGeneratorInterface $tokenGenerator,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response {
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //On va chercher l'utilisateur par son email
            $user = $usersRepository->findOneByEmail($form->get('email')->getData());

            // On vérifie si on a un utilisateur
            if ($user) {
                // On génère un token de réinitialisation
                $token = $tokenGenerator->generateToken();
                $user->setResetToken($token);
                $entityManager->persist($user);
                $entityManager->flush();

                // On génère un lien de réinitialisation du mot de passe
                $url = $this->generateUrl('reset_pass', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

                // On crée les données du mail
                $context = compact('url', 'user');

                // Envoi du mail
                $email = (new TemplatedEmail())
                    // email address as a simple string
                    ->to($user->getEmail())
                    ->subject('Réinitialisation de mot de passe')
                    ->htmlTemplate('security/templatemail.html.twig')

                    // pass variables (name => value) to the template
                    ->context([
                        "url" => $context["url"],
                        "name" => $user->getNom()
                    ]);
                $mailer->send($email);


                $this->addFlash('success', 'Email envoyé avec succès');
                return $this->redirectToRoute('app_login');
            }
            // $user est null
            $this->addFlash('danger', 'Un problème est survenu');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset_password_request.html.twig', [
            'requestPassForm' => $form->createView()
        ]);
    }

    #[Route('/oubli-pass/{token}', name: 'reset_pass')]
    public function resetPass(
        string $token,
        Request $request,
        UserRepository $usersRepository,
        EntityManagerInterface $entityManager,

    ): Response {
        // On vérifie si on a ce token dans la base
        $user = $usersRepository->findOneByResetToken($token);

        if ($user) {
            $form = $this->createForm(ResetPasswordFormType::class);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // On efface le token
                $user->setResetToken('');
                $encodedPassword = password_hash($form->get('password')->getData(), PASSWORD_DEFAULT);

                $user->setMdp($encodedPassword);




                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Mot de passe changé avec succès');
                return $this->redirectToRoute('app_login');
            }

            return $this->render('security/reset_password.html.twig', [
                'passForm' => $form->createView()
            ]);
        }
        $this->addFlash('danger', 'Jeton invalide');
        return $this->redirectToRoute('app_login');
    }
}
