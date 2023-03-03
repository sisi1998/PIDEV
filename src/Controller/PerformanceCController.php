<?php

namespace App\Controller;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Repository\PerformanceCRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\PerformanceC;
use App\Entity\Competition;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Form\PerformanceContactType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
    public function listPerformanceF(Request $request,Swift_Mailer  $mailer):Response
    { 
        $performanCes = $this->getDoctrine()->getRepository(PerformanceC::class)->findAll();
        if(!$performanCes)
        {throw new NotFoundHttpException('not');}
        $form = $this-> createForm(PerformanceContactType::class);
        $contact = $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
       
              //BUNDLE MAILER
              $message = (new Swift_Message('Performandce.'))
              ->setFrom($contact->get('email')->getData())
              ->setTo("siwar.najjar@esprit.tn")
              ->setBody($contact->get('message')->getData());

          //send mail
          $mailer->send($message);

          //jarb testi  chouf

            

            // On confirme et on redirige
            $this->addFlash('message', 'Votre e-mail a bien été envoyé');}

        return $this->render('performance_c/listFO.html.twig', ["performances" => $performanCes,'form'=>$form->createView()]);
    }

// le ghalt lazm tkoun actgei twig ta3 affd tempalte
//ay na3ref ama l fonc heki 3aandha twig trandriha nhezek ghadi ? pas forcement eno kdha twig exemlpe delete endhach twig action kaho hata pdf akak

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
     * @Route("/showp/{id}", name="showPerformance")
     */
    public function showCPerformance($id)
    {
       
        $perofrmanceC = $this->getDoctrine()->getRepository(PerformanceC::class)->find($id);
        return $this->render('Performance_c/showBO.html.twig', array("performanceC" => $perofrmanceC  ));
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






        //RECHERCHE :
            /**
     * @Route("/ajax_search/", name="ajax_search")
     */
    public function chercher(\Symfony\Component\HttpFoundation\Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');// ooofkdokfdfdf
        $comp =  $em->getRepository(PerformanceC::class)->rechercheAvance($requestString);
        if(!$comp) {
            $result['comp']['error'] = "Competition de ce joueur non trouvé :( ";
        } else {
            $result['comp'] = $this->getRealEntities($comp);
        }
        return new Response(json_encode($result));
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

    //this 2nd chart

    
  

    return $this->render('performance_c/stats.html.twig', [
         'data' =>$data, 'data2'=>$data2
    ]);
}




   /**
     * @Route("/con-chart{id}", name="con_chart")
     */
    public function chart(EntityManagerInterface $em1,$id)
    {  $perfs = $em1->getRepository(PerformanceC::class)->average($id);
        dd($perfs);
        return $this->render('performance_c/stats.html.twig');
    }
    
}
