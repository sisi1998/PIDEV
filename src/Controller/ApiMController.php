<?php

namespace App\Controller;

use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Competition;
use App\Repository\PerformanceCRepository;
use App\Entity\PerformanceC;
use App\Repository\CompetitionRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CompetitionType;
use App\Form\CompetitionSearchType;
use App\Form\CompetitionUpadateType;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
class ApiMController extends AbstractController
{
    #[Route('/api/m', name: 'app_api_m')]
    public function index(): Response
    {
        return $this->render('api_m/index.html.twig', [
            'controller_name' => 'ApiMController',
        ]);
    }




     /**
     * @Route("/listCompetitionM", name="listCompetitionM")
     */
    public function listCompetitonM(CompetitionRepository $repo,NormalizerInterface $normalizer)
    {
        $competitions = $repo->findAll();
        $CompNorm = $normalizer ->normalize( $competitions,'json',['groups'=>"competitions"]);
        $json= json_encode($CompNorm);
        return new Response($json);
    }

 /**
     * @Route("/deleteM/{id}", name="DeleteM")
    
     */
    public function deleteM(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer)
{
    $id = $request->attributes->get('id');
    $comp = $entityManager->getRepository(Competition::class)->find($id);

    if (!$comp) {
        throw $this->createNotFoundException(sprintf('No resource found with id "%s"', $id));
    }

    $entityManager->remove($comp);
    $entityManager->flush();

    $json = $serializer->serialize(['message' => sprintf('Resource with id "%s" deleted', $id)], 'json');
    return new Response($json, Response::HTTP_OK, ['Content-Type' => 'application/json']);
}


    
 

     
  /**
     * @Route("/addM", name="addCompetitionM")
     */
    public function addCompetitionM(Request $req, SerializerInterface $serializer, EntityManagerInterface $em)
    {
      $content=$req->getContent();
      $data=$serializer->deserialize($content,Competition::class,'json');
     $em->persist($data);
     $em->flush();

        return new Response(' added');
        
       
    } 


  /**
     * @Route("/editM", name="editMCompetitionM")
     */
    public function updateCompetitionM(Request $request, SerializerInterface $serializer, CompetitionRepository $cr, int $id): JsonResponse
    {
        // fetch the record from the repository using the ID
        $comp = $cr->find($id);

        if (!$comp) {
            return new JsonResponse(['error' => 'Record not found.'], JsonResponse::HTTP_NOT_FOUND);
        }

        // deserialize the request data into the record entity
        $serializer->deserialize($request->getContent(), Competition::class, 'json', ['object_to_populate' => $comp]);

        // save the updated record to the database
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comp);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Record updated successfully.']);
    }

}
