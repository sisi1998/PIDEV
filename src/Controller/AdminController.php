<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(Request $request): Response
    {
        $admin = $request->getSession()->get('user');
        if ($admin->getRole() === "admin") {

            return $this->render('admin/home.html.twig', ['admin' => $admin]);
        } else {
            return $this->redirectToRoute('app_my_profile', [], Response::HTTP_SEE_OTHER);
        }
    }
}
