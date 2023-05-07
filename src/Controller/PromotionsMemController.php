<?php

namespace App\Controller;

use doctrine;
use App\Entity\CatMembership;
use App\Entity\PromotionsMem;
use App\Form\AddpromotionType;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\PromotionsMemRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PromotionsMemController extends AbstractController
{
    #[Route('/promotions/mem', name: 'app_promotions_mem')]
    public function promotion(): Response
    {
        return $this->render('back/promotions/promotions.html.twig', [
            'controller_name' => 'PromotionsMemController',
        ]);
    }
    
    #[Route('/showpromotion/{id}', name: 'showpromotion')]
    public function detailPromotion(PromotionsMemRepository $repo,$id): Response
    {
        $promo=$repo->find($id);
        return $this->render('back/promotions/show.html.twig', [
            'promotions' => $promo,
        ]);
        // dd($promo);
    }
    #[Route('/promotions', name: 'promotions')]
    public function listPromotions(ManagerRegistry $mg): Response
    {
    $repo=$mg->getRepository(PromotionsMem::class);
    $result=$repo->findAll();
    
        return $this->render('back/promotions/promotions.html.twig', [
            'promos' => $result,
        ]);
         
        //  dd($result);
    }

    #[Route('/addpromotion', name: 'app_addpromotion')]
    public function addPromotion(Request $request,ManagerRegistry $mg): Response
    {   
        
    //   $list= $this->getdoctrine()->getManager() ->getRepository(CatMembership::class)->mem_without_promo();

        $catMembership=new CatMembership();
        $promo = new PromotionsMem();
        $form = $this->createForm(AddpromotionType::class, $promo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $catMembership->setPromotion($promo);
            $em=$mg->getManager();
            $em->persist($promo);
            
            $em->flush();
            

            return $this->redirectToRoute('promotions');
        }

        return $this->render('back/promotions/new.html.twig',[
            'form' => $form->createView(),
            'promo'=>$promo,
            'mem'=>$catMembership,
            
            
            
            
        ]);
    }

    #[Route('updatepromotion/{id}', name: 'updatepromotion')]
    public function updatePromotion(Request $request, $id, PromotionsMemRepository $repo,
    ManagerRegistry $mg
    ): Response
    {$memup=$repo->find($id);
        $form = $this->createForm(AddpromotionType::class, $memup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
         $em=$mg->getManager();
         $em->persist($memup); 
         $em->flush();
            return $this->redirectToRoute('promotions');
        }

        return $this->renderForm('back/promotions/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('removepromotion/{id}', name: 'removepromotion')]
    public function deletePromotion($id, PromotionsMemRepository $repo,ManagerRegistry $mg): Response
    {
        $em=$mg->getManager();
            $result=$repo->find($id);
            $em->remove($result);
            $em->flush();

        return $this->redirectToRoute('promotions');
    }
}
