<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


#[Route('/user')]
class UserController extends AbstractController
{

    #[Route('/recherche_ajax', name: 'recherche_ajax')]

    public function rechercheAjax(Request $request, UserRepository $sr): JsonResponse
    {
        $requestString = $request->query->get('searchValue');
        $resultats = $sr->findUserByNsc($requestString);
        return $this->json($resultats);
    }



    #[Route('/search', name: 'app_user_search')]
    public function searchzebi(UserRepository $userRepository, Request $request): Response

    {
        $admin = $request->getSession()->get('user');
        if ($admin->getRole() === "admin") {
            return $this->render('user/search.html.twig', [
                'users' => $userRepository->findAll(), 'admin' => $admin
            ]);
        } else {
            return $this->redirectToRoute('app_my_profile', [], Response::HTTP_SEE_OTHER);
        }
    }


    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, Request $request): Response
    {
        $admin = $request->getSession()->get('user');

        if ($admin->getRole() === "admin")
            return $this->render('user/index.html.twig', [
                'users' => $userRepository->findAll(),
                'admin' => $admin
            ]);
        else {
            return $this->redirectToRoute('app_my_profile', [], Response::HTTP_SEE_OTHER);
        }
    }


    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository, SluggerInterface $slugger): Response
    {
        $admin = $request->getSession()->get('user');
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();

            // // this condition is needed because the 'brochure' field is not required
            // // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

                //     // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('user_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setImage($newFilename);
            }



            // Crypter le mot de passe avant de l'affecter à l'utilisateur
            $password = $form->get('mdp')->getData();
            $encodedPassword = password_hash($password, PASSWORD_DEFAULT);
            $user->setMdp($encodedPassword);

            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
        if ($admin->getRole() === "admin") {

            return $this->renderForm('user/new.html.twig', [
                'user' => $user,
                'form' => $form,
                'admin' => $admin
            ]);
        } else {
            return $this->redirectToRoute('app_my_profile', [], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/{id}/show', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user, Request $request): Response

    {
        $admin = $request->getSession()->get('user');
        if ($admin->getRole() === "admin") {
            return $this->render('user/show.html.twig', [
                'user' => $user,
                'admin' => $admin
            ]);
        } else {
            return $this->redirectToRoute('app_my_profile', [], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $admin = $request->getSession()->get('user');

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();

            // // this condition is needed because the 'brochure' field is not required
            // // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

                //     // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('user_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setImage($newFilename);
            }

            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
        if ($admin->getRole() === "admin") {
            return $this->renderForm('user/edit.html.twig', [
                'user' => $user,
                'form' => $form,
                'admin' => $admin
            ]);
        } else {
            return $this->redirectToRoute('app_my_profile', [], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }




    // TO-DO: page d'acceuil 
}
