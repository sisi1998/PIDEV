<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Entity\Competition;
use App\Repository\PerformanceCRepository;
use Doctrine\ORM\EntityRepository; // import the EntityRepository class
use App\Entity\PerformanceC;
use App\Repository\CompetitionRepository;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        return $this->render('baseBOcom.html.twig', [
            'controller_name' => 'CompetitionController',
        ]);
    }
    


    


      /**
     * @Route("/update/{id}", name="updateCompetition")
     */
    public function updateCompetition(Request $request, $id, SluggerInterface $slugger)

    {
        
        $competition = $this->getDoctrine()->getRepository(Competition::class)->find($id);
        $equipes=$competition->getEquipes();
        $form = $this->createForm(CompetitionUpadateType::class, $competition);
        $form->add("Modifier", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
            $image = $form->get('image')->getData();
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
                $competition->setImage($newFilename);
            }



            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listCompetition');
        }
        return $this->render("competition/updateBO.html.twig", array('form' => $form->createView(),'equipes'=> $equipes));
    }

     /**
     * @Route("/listCompetition", name="listCompetition")
     */
    public function listCompetiton(Request $request)
    {
      
        $competitions = $this->getDoctrine()->getRepository(Competition::class)->findAll();
        return $this->render('competition/listBO.html.twig', ["competitions" => $competitions]);
    }

     /**
     * @Route("/listCompetitionF", name="listCompetitionF")
     */
    public function listCompetitonF(Request $request)
    {   $competitions = $this->getDoctrine()->getRepository(Competition::class)->findAll();

      
        $form = $this->createForm( CompetitionSearchType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $nom= $form->get('Nom')->getData();
            $em = $this->getDoctrine()->getManager();
            $comp=$em->getRepository(Competition::class)->searchByCriteria($nom);
        

           if($comp) {
            
                return $this->render('competition/listFO.html.twig',  ["competitions" => $comp,'form'=>$form->createView()]);
        }}
           return $this->render('competition/listFO.html.twig', ["competitions" => $competitions,'form'=>$form->createView()]);
    }



    
    /**
     * @Route("/competition/search", name="competition_search", methods={"GET"})
     */
    public function searchAjQ(Request $request, CompetitionRepository $competitionRepository): JsonResponse
    {
        $searchTerm = $request->query->get('q');
        $competitions = $competitionRepository->searchByName($searchTerm);

        return $this->json($competitions);
    }

    /**
     * @Route("/addC", name="addCompetition")
     */
    public function addCompetition(Request $request,SluggerInterface $slugger)
    {
        $competition = new Competition();
        
        $form = $this->createForm( CompetitionType::class,  $competition);
     
      
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
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
                $competition->setImage($newFilename);
            }

  

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







    //   //RECHERCHE :
    //         /**
    //  * @Route("/ajax_search/", name="ajax_search")
    //  */
    // public function chercher(\Symfony\Component\HttpFoundation\Request $request)
    // {
    //     $em = $this->getDoctrine()->getManager();
    //     $requestString = $request->get('q');// ooofkdokfdfdf
    //     $comp =  $em->getRepository(Competition::class)->rechercheAvance($requestString);
    //     if(!$comp) {
    //         $result['comp']['error'] = "Competition de ce Nom non trouvé :( ";
    //     } else {
    //         $result['comp'] = $this->getRealEntities($comp);
    //     }
    //     return new Response(json_encode($result));
    // }





    // LES  attributs
    public function getRealEntities($comp){
        foreach ($comp as $comp){
            $realEntities[$comp->getId()] = [$comp->getNom(),$comp->getDate()];

        }
        return $realEntities;
    }




     /**
     * @Route("/searchC{id}", name="searchC")
     */
    public function search(Request $request)
    {
        $form = $this->createForm(CompetitionSearchType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nom= $form->get('Nom')->getData();
            $etat= $form->get('Etat')->getData();
            $date= $form->get('Date')->getData();
            $em = $this->getDoctrine()->getManager();

            $comp=$em->getRepository(Competition::class)->searchByCriteria($nom, $date, $etat);
            if(!$comp) {
                $result['comp']['error'] = "Competition de ce Nom non trouvé :( ";
            } else {
                $this->render('competition/showBO.html.twig', array("competition" => $comp ));
            }
        }

        return $this->render('competition/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function ajaxSearch($joueurName)
{
    $em = $this->getDoctrine()->getManager();

    $performances = $em->getRepository(PerformanceC::class)
        ->createQueryBuilder('p')
        ->leftJoin('p.joueur', 'j')
        ->where('j.nom = :joueurName')
        ->setParameter('joueurName', $joueurName)
        ->getQuery()
        ->getResult();

    $data = array();
    foreach ($performances as $performance) {
        $data[$performance->getId()] = array(
            'performanceName' => $performance->getName(),
        );
    }

    return new JsonResponse($data);
}
}