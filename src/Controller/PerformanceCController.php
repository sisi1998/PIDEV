<?php

namespace App\Controller;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Dompdf\Dompdf;
use Doctrine\ORM\EntityRepository; // import the EntityRepository class

use Dompdf\Options;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\PerformanceCRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\PerformanceC;
use App\Entity\User;
use App\Entity\Competition;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Form\PerformanceContactType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PerformanceCType;
use Symfony\Component\Mime\Email;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\SendMailService;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\Mailer\MailerInterface;

class PerformanceCController extends AbstractController



{



     private $entityManager;

    #[Route('/performance/c', name: 'app_performance_c')]
    public function index(): Response
    {
        return $this->render('performance_c/index.html.twig', [
            'controller_name' => 'PerformanceCController',
        ]);
    }

  /**
     * @Route("/listP", name="listPerformance")
     */
    public function listPerformance()
    {
        $performanCes = $this->getDoctrine()->getRepository(PerformanceC::class)->findAll();
        return $this->render('performance_c/listBO.html.twig', ["performances" => $performanCes]);
    }



    

  /**
     * @Route("/listPF", name="listPerformanceF")
     */
    public function listPerformanceF(EntityManagerInterface $em1)
    { 
        $performanCes = $this->getDoctrine()->getRepository(PerformanceC::class)->findAll();
     $but = $em1->getRepository(PerformanceC::class)->sumButs();
    $rouge = $em1->getRepository(PerformanceC::class)->sumRouge();
    $jaune = $em1->getRepository(PerformanceC::class)->sumJaune();
    $pd = $em1->getRepository(PerformanceC::class)->sumPointsDecisives();
    $ag = $em1->getRepository(PerformanceC::class)->sumAeriensG();
    $tpm = $em1->getRepository(PerformanceC::class)->sumTpM();
  
    $data=[$but,$rouge,$jaune,$pd,$ag,$tpm];
    $players = $this->entityManager->getRepository(User::class)->findAllJoueurs();
        return $this->render('performance_c/listFO.html.twig', ["performances" => $performanCes,'data' =>$data, 'but'=>$but,'pd'=>$pd,'ag'=>$ag , 'tpm'=>$tpm,"players" => $players, ]);
    }



    #[Route('/contact', name: 'contact')]
    public function contactUs(Request $request,Swift_Mailer $mailer)
    { 
        $form = $this-> createForm(PerformanceContactType::class);
        $contact = $form->handleRequest($request);
         $name=$form->get('Nom')->getData();
         $ctn=$form->get('message')->getData();
         $titre=$form->get('title')->getData();
        if($form->isSubmitted()){
            $message = (new Swift_Message('Reclammation Joueur'))
              ->setFrom($contact->get('email')->getData())
              ->setTo("siwar.najjar@esprit.tn")
             // ->setBody($contact->get('message')->getData())
              ->setBody(
                $this->renderView(
                    // templates/emails/registration.html.twig
                    'emails/contact.html.twig',
                    ['name' => $name,'ctn'=> $ctn, 'title'=>$titre]
                ),
                'text/html'
            );
          $mailer->send($message);
            $this->addFlash('message', 'Votre e-mail a bien été envoyé');}
           
    
        return $this->render('performance_c/contactUS.html.twig', ['form'=>$form->createView()]);
    }


     /**
     * @Route("/addP", name="addPerformance")
     */
    public function addPerformanceC(Request $request)
    {
        $performanceC = new  PerformanceC();
        $form = $this->createForm( PerformanceCType::class,  $performanceC);
        
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //$student->setMoyenne(0);
            $em->persist( $performanceC);
            $em->flush();
            return $this->redirectToRoute("listPerformance");
        }
       return $this->render("performance_c/addBO.html.twig", array('form' => $form->createView()));

    }



    /**
     * @Route("/deletep/{id}", name="deletePerformance")
     */
    public function deletePerformance($id)
    {
        $perofrmanceC = $this->getDoctrine()->getRepository(PerformanceC::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($perofrmanceC);
        $em->flush();
        return $this->redirectToRoute("listPerformance");
    }



  /**
     * @Route("/updatep/{id}", name="updatePerformance")
     */
    public function updatePerformance(Request $request, $id)
    {
        $perofrmanceC = $this->getDoctrine()->getRepository(PerformanceC::class)->find($id);
        $form = $this->createForm(PerformanceCType::class, $perofrmanceC);
        $form->add("Modifier", SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listPerformance');
        }
        return $this->render("performance_c/updateBO.html.twig", array('form' => $form->createView()));
    }

    public function deletePerformanceF($competition)
    {
        $perofrmanceC = $this->getDoctrine()->getRepository(PerformanceC::class)->find($competition);
        $em = $this->getDoctrine()->getManager();
        $em->remove($perofrmanceC);
        $em->flush();
        return $this->redirectToRoute("listPerformance");
      
    }
    
     /**
     * @Route("/listByComp", name="listByComp)
     */
   // public function listPerformanceByCompetition($competition)
    //{

      //  $perofrmanceC = $this->getDoctrine()->getRepository(PerformanceC::class)->findByCompetition($competition);
       // return $this->render('Performance_c/show.html.twig', array("performanceC" => $perofrmanceC  ));
       
   // } */


    /**
     * @Route("/exportPdf", name="exportPdf")
     */
    public function generatePdf(){
   
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        //get list perfo
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('pdf/template.html.twig', [
            'title' => "Toutes vos performances",
            'listP'=>$this->getDoctrine()->getRepository(PerformanceC::class)->findAll(),
        ],);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
    
        $dompdf->render();
        return new Response (
            $dompdf->stream('resume', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );    }




        #[Route('/ajax_search', name: 'ajax_search')]
        public function rechercheAjax(Request $request, PerformanceCRepository $sr): JsonResponse
        {   
      
            $requestString2 = $request->query->get('nom');
            $resultats = $sr->fpc($requestString2);
            return $this->json($resultats);
        }
        



    public function searchAdd(Request $request): JsonResponse
    {
        $query = $request->query->get('q');

       

        $results = []; // Replace with actual search results

        return new JsonResponse($results);
    }



    // LES  attributs
    public function getRealEntities($comp){
        foreach ($comp as $comp){
            $realEntities[$comp->getId()] = [$comp->getDate()];

        }
        return $realEntities;
    }

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/sales-data", name="sales_data")
     */
public function stats(EntityManagerInterface $em1){


    $but = $em1->getRepository(PerformanceC::class)->sumButs();
    $rouge = $em1->getRepository(PerformanceC::class)->sumRouge();
    $jaune = $em1->getRepository(PerformanceC::class)->sumJaune();
    $pd = $em1->getRepository(PerformanceC::class)->sumPointsDecisives();
    $ag = $em1->getRepository(PerformanceC::class)->sumAeriensG();
    $data=[$but,$pd,$ag];
    $data2=[$rouge,$jaune];

    $players = $this->entityManager->getRepository(User::class)->findAllJoueurs();

    return $this->render('performance_c/stats.html.twig', [
         'data' =>$data, 'data2'=>$data2, "players" => $players
    ]);
}




   /**
     * @Route("/con-chart{id}", name="con_chart")
     */
    public function chart(EntityManagerInterface $em1,$id)
    {  $perfs = $em1->getRepository(PerformanceC::class)->average($id);
        
        return $this->render('performance_c/stats.html.twig');
    }
   
    

 /**
     * @Route("/showp/{id}", name="showPerformance")
     */
    public function showCPerformance(EntityManagerInterface $em1,  EntityManagerInterface  $em2,$id)
    {
       
      $data = $em1->getRepository(PerformanceC::class)->average($id);
      $values = array(); // create new array to hold the averages
  
      foreach ($data as $item) { // loop through the $data array
          $average = $item['average']; // get the "average" value of each item
          array_push($values, $average); // add the "average" value to the $averages array
      }

      $perfs=$em2->getRepository(PerformanceC::class)->findByPlayerId($id);
      
 
        return $this->render('Performance_c/showFO.html.twig', [
            'data' =>$values ,'perfs'=>$perfs]);
    }



//  /**
//      * @Route("/search-performance", name="search_performance", methods={"GET"})
//      */
//     public function search(Request $request, UserRepository $UserRepository, CompetitionRepository $competitionRepository, PerformanceRepository $performanceRepository): JsonResponse
//     {
//         $playerName = $request->query->get('player_name');
//         $competitionName = $request->query->get('competition_name');

//         $player = $UserRepository->findOneBy(['name' => $playerName]);
//         $competition = $competitionRepository->findOneBy(['name' => $competitionName]);

//         if (!$player || !$competition) {
//             return new JsonResponse(['error' => 'Player or competition not found'], 404);
//         }

//         $performances = $performanceRepository->findBy(['joueur' => $player, 'competition' => $competition]);

//         return new JsonResponse($performances);
  //  }


    
}






