<?php

namespace App\Controller;

use App\Entity\Competition;
use App\Repository\PerformanceCRepository;
use App\Entity\PerformanceC;
use App\Repository\CompetitionRepository;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CompetitionType;
use App\Form\CompetitionSearchType;
use App\Form\CompetitionUpadateType;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CompetitionController extends AbstractController
{
    #[Route('/', name: 'app_competition')]
    public function index(): Response
    {
        return $this->render('baseBO.html.twig', [
            'controller_name' => 'CompetitionController',
        ]);
    }
    


      /**
     * @Route("/update/{id}", name="updateCompetition")
     */
    public function updateCompetition(Request $request, $id)
    {
        $competition = $this->getDoctrine()->getRepository(Competition::class)->find($id);
        $form = $this->createForm(CompetitionUpadateType::class, $competition);
        $form->add("Modifier", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listCompetition');
        }
        return $this->render("competition/updateBO.html.twig", array('form' => $form->createView()));
    }

     /**
     * @Route("/listCompetition", name="listCompetition")
     */
    public function listCompetiton(Request $request)
    {
      
        $competition = new Competition();
        $form = $this->createForm( CompetitionSearchType::class, $competition);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $competitionN=$this->getDoctrine()->getRepository(Competition::class)->findOneBy(['Nom'=>$form->get('Nom')->getData()]);
            return $this->render('competition/showBO.html.twig', array("competition" => $competitionN ));}
       
        $competitions = $this->getDoctrine()->getRepository(Competition::class)->findAll();
        return $this->render('competition/listBO.html.twig', ["competitions" => $competitions,'form'=>$form->createView()]);
    }

     /**
     * @Route("/listCompetitionF", name="listCompetitionF")
     */
    public function listCompetitonF(Request $request)
    {   $competitions = $this->getDoctrine()->getRepository(Competition::class)->findAll();

        $competition = new Competition();
       /*  $form = $this->createForm( CompetitionSearchType::class, $competition);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $nom= $form->get('Nom')->getData();
            $etat= $form->get('Etat')->getData();
            $genre= $form->get('Genre')->getData();
            $comp=new Competition();
            $comp->setNom($nom);
            $comp->setEtat($etat);
            $comp->setGenre($genre);
            $em = $this->getDoctrine()->getManager();
            $competitiony=$em->getRepository(Competition::class)->findBycritere($comp);
            if ($competitiony)
           {return $this->render('competition/listFO.html.twig', ["competitions" => $competitiony,'form'=>$form->createView()]);}
           else {return $this->render('competition/listFO.html.twig', ["competitions" => $competitions,'form'=>$form->createView()]);}
        */return $this->render('competition/listFO.html.twig', ["competitions" => $competitions]);
    }



    /**
     * @Route("/add", name="addCompetition")
     */
    public function addCompetition(Request $request)
    {
        $competition = new Competition();
        
        $form = $this->createForm( CompetitionType::class,  $competition);
     
      
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {

  

            $em = $this->getDoctrine()->getManager();
            //$student->setMoyenne(0);
            $em->persist( $competition);
            $em->flush();
            return $this->redirectToRoute("listCompetition");
        }
       return $this->render("competition/addBO.html.twig", array('form' => $form->createView()));
    }

     /**
     * @Route("/delete/{id}", name="deleteCompetmition")
     */
    public function deleteCompetition($id)
    {
             
        $competition = $this->getDoctrine()->getRepository(Competition::class)->find($id);
        $em = $this->getDoctrine()->getManager();
     
        $em->remove($competition);
        $em->flush();
        return $this->redirectToRoute("listCompetition");
    }

    /**
     * @Route("/show/{id}", name="showCompetition")
     */
    public function showCompetition($id)
    {
        $competition = $this->getDoctrine()->getRepository(Competition::class)->find($id);
        return $this->render('competition/showBO.html.twig', array("competition" => $competition ));
    }

 /**
     * @Route("/showF/{id}", name="showCompetitionF")
     */
    public function showCompetitionF($id)
    {
        $competition = $this->getDoctrine()->getRepository(Competition::class)->find($id);
        return $this->render('competition/showFO.html.twig', array("competition" => $competition ));
    }





    

 /**
     * @Route("/showFN/{nom}", name="showCompetitionFN")
     */
    public function showCompetitionFN(CompetitionRepository $rep,$nom) { 
   
        $competitions= $rep->findOneByNom($nom);
        return $this->render('competition/showFO.html.twig', [
            "competitions" => $competitions,
        ]);

}







      //RECHERCHE :
            /**
     * @Route("/ajax_search/", name="ajax_search")
     */
    public function chercher(\Symfony\Component\HttpFoundation\Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');// ooofkdokfdfdf
        $comp =  $em->getRepository(Competition::class)->rechercheAvance($requestString);
        if(!$comp) {
            $result['comp']['error'] = "Competition de ce Nom non trouvé :( ";
        } else {
            $result['comp'] = $this->getRealEntities($comp);
        }
        return new Response(json_encode($result));
    }





    // LES  attributs
    public function getRealEntities($comp){
        foreach ($comp as $comp){
            $realEntities[$comp->getId()] = [$comp->getNom(),$comp->getDate()];

        }
        return $realEntities;
    }


}