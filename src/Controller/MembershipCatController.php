<?php

namespace App\Controller;

use doctrine;
use App\Entity\CatMembership;
use App\Form\AddmembershipType;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CatMembershipRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MembershipCatController extends AbstractController
{
    #[Route('/membership/cat', name: 'membershipfront')]
    public function home(): Response
    {
        return $this->render('basemem.html.twig', [
            'controller_name' => 'MembershipCatController',
        ]);
    }
    #[Route('/showmembership/{id}', name: 'app_membershipplans')]
    public function showMembership(CatMembershipRepository $repo,$id): Response
    {
        $catMembership=$repo->find($id);
        return $this->render('back/memberships/show.html.twig', [
            'catMembership' => $catMembership,
        ]);
        // dd($catMembership);
    }
    #[Route('/memberships', name: 'memberships')]
    public function listMemberships(ManagerRegistry $mg): Response
    {
    $repo=$mg->getRepository(CatMembership::class);
    $result=$repo->findAll();
        return $this->render('back/memberships/memplans.html.twig', [
            'catMemberships' => $result,
        ]);
    }

    #[Route('/addmembership', name: 'app_addmembership')]
    public function addMembership(Request $request,ManagerRegistry $mg): Response
    {
       
        
        
        $catMembership = new CatMembership();
        $form = $this->createForm(AddmembershipType::class, $catMembership);
        $form->handleRequest($request);

        if ($form->isSubmitted()  ) {
            $em=$mg->getManager();
            $em->persist($catMembership);
            $em->flush();
            return $this->redirectToRoute('memberships');
        }

        return $this->render('back/memberships/new.html.twig',[
            'form' => $form->createView(),
            'mem'=>$catMembership
        ]);
    }

    #[Route('updatemembership/{id}', name: 'updatemembership')]
    public function updateMembership(Request $request, $id, CatMembershipRepository $repo,
    ManagerRegistry $mg
    ): Response
    {$memup=$repo->find($id);
        $form = $this->createForm(AddMembershipType::class, $memup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
         $em=$mg->getManager();
         $em->persist($memup); 
         $em->flush();
            return $this->redirectToRoute('memberships');
        }

        return $this->renderForm('back/memberships/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('removemembership/{id}', name: 'removemembership')]
    public function deleteMembership($id, CatMembershipRepository $repo,ManagerRegistry $mg): Response
    {
        $em=$mg->getManager();
            $result=$repo->find($id);
            $em->remove($result);
            $em->flush();

        return $this->redirectToRoute('memberships');
    }
}



   

