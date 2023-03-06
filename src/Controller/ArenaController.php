<?php

namespace App\Controller;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ArenaRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ArenaAFormType;
use App\Entity\Arena;

class ArenaController extends AbstractController
{
    #[Route('/arena', name: 'app_arena')]
    public function index(): Response
    {
        return $this->render('arena/index.html.twig', [
            'controller_name' => 'ArenaController',
        ]);
    }
    #[Route('createArenaa', name: 'app_createArenaa')]
    public function createArenaa(Request $request)
    {
        $Arena = new Arena();
        $form = $this->createForm(ArenaAFormType::class, $Arena);
        $form->add("Enregistrer", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
          
            $em->persist($Arena);
            $em->flush();
          
        }
        return $this->render("arena/ajouterarena.html.twig", array('formA' => $form->createView()));
    }


    #[Route('/showarena', name:'showarena' )]
    public function showarena()
    {
        $Arena = $this->getDoctrine()->getRepository(Arena::class)->findAll();
        return $this->render('arena/showlistarena.html.twig', [
            'Arena' => $Arena,
           ]);
      
    }
     
    #[Route('/deleteArena/{id}', name:'deleteArena' )]
    
    
    
       public function delete($id):Response
        {
            $Arena = $this->getDoctrine()->getRepository(Arena::class)->find($id);
            $em = $this->getDoctrine()->getManager();
            $em->remove($Arena);
            $em->flush();
            return $this->redirectToRoute('showarena');
    
           }
        
    

    #[Route('/updateArena/{id}', name:'updateArena')]
    public function update(Request $request,$id)
    {
        $Arena = $this->getDoctrine()->getRepository(Arena::class)->find($id);
        $form = $this->createForm(ArenaAFormType::class, $Arena);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
          
            return $this->redirectToRoute('showarena');
        }
        return $this->render("arena/updateArena.html.twig",array('formA'=>$form->createView()));
    }

   
}



