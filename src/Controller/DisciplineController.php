<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Equipe;
use App\Repository\EquipeRepository;
use App\Entity\DISCIPLINE;
use App\Form\DISCIPLINEType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class DisciplineController extends AbstractController
{
    #[Route('/discipline', name: 'app_discipline')]
    public function index(): Response
    {
        return $this->render('discipline/index.html.twig', [
            'controller_name' => 'DisciplineController',
        ]);
    }
    #[Route('/suividiscipline', name:'suividiscipline')]
    public function suiviD(Request $request)
    {
        $DISCIPLINE= new DISCIPLINE();
        $form = $this->createForm(DISCIPLINEType::class, $DISCIPLINE);
        $form->add("Enregistrer", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
           
            $em->persist($DISCIPLINE);
            $em->flush();
          
        }
        return $this->render("discipline/add.html.twig", array('formD' => $form->createView()));
    }
    #[Route('/showD', name:'showD')]
     public function showD()
     {
        $DISCIPLINE= $this->getDoctrine()->getRepository(DISCIPLINE::class)->findAll();
        $D= $this->getDoctrine()->getRepository(Equipe::class)->findAll();
    
         return $this->render('discipline/cc.html.twig', [
             'DISCIPLINE' => $DISCIPLINE,
             'Dequipe' => $D,
             
            ]);
       
     }
}
