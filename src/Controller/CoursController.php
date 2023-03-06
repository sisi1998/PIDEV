<?php

namespace App\Controller;
use App\Entity\Cours;
use App\Entity\Arena;
use App\Form\CoursFormType;
use App\Repository\CoursRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursController extends AbstractController
{
    #[Route('/cours', name: 'app_cours')]
    public function index(): Response
    {
        return $this->render('cours/index.html.twig', [
            'controller_name' => 'CoursController',
        ]);
    }
    #[Route('/createCours', name:'createCours')]
     public function createCours(Request $request)
     {
         $Cours = new Cours();
         $form = $this->createForm(CoursFormType::class, $Cours);
         $form->add("Enregistrer", SubmitType::class);
         $form->handleRequest($request);
         if ($form->isSubmitted()) {
             $em = $this->getDoctrine()->getManager();
            
             $em->persist($Cours);
             $em->flush();
           
         }
         return $this->render("cours/ajoutercours.html.twig", array('form' => $form->createView()));
     }
     #[Route('/showCours', name:'showCours')]
     public function showCours()
     {
         $Cours= $this->getDoctrine()->getRepository(Cours::class)->findAll();
         return $this->render('cours/listCours.html.twig', [
             'Cours' => $Cours,
            ]);
       
     }
     #[Route('/deleteCours/{id}', name:'deleteCours' )]
    
    
    
       public function deleteC($id):Response
        {
            $Cours= $this->getDoctrine()->getRepository(Cours::class)->find($id);
            $em = $this->getDoctrine()->getManager();
            $em->remove($Cours);
            $em->flush();
            return $this->redirectToRoute('showCours');
    
           } 
           #[Route('/updateCours/{id}', name:'app_updateCours')]
           public function updateC(Request $request,$id)
           {
              $Cours = $this->getDoctrine()->getRepository(Cours::class)->find($id);
               $form = $this->createForm(CoursFormType::class, $Cours);
               $form->add('Modifier',SubmitType::class);
               $form->handleRequest($request);
               if ($form->isSubmitted()) {
                   $em = $this->getDoctrine()->getManager();
                   $em->flush();
                 
                   return $this->redirectToRoute('showarena');
               }
               return $this->render("cours/updateCours.html.twig",array('form'=>$form->createView()));
           }
       

}
