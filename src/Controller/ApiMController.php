<?php

namespace App\Controller;

use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Competition;
use App\Entity\Equipe;
use App\Entity\Joueur;
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
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface as SerializationSerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
class ApiMController extends AbstractController
{



    /**
     * @Route("/listPerf", name="listPerf")
     */
    public function listCompetitonM(PerformanceCRepository $repo,NormalizerInterface $normalizer)
    {
        $performances = $repo->findAll();
        $CompNorm = $normalizer ->normalize( $performances,'json',['groups'=>"performances"]);
        $json= json_encode($CompNorm);
        return new Response($json);
    }

    /**
     * @Route("/deletePer/{id}", name="DeleteM")

     */
    public function deletePer(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $id = $request->get('id');
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
     * @Route("/addPerf", name="addPerf")
     */
    public function addPerformanceM(Request $req, SerializerInterface $serializer, EntityManagerInterface $em)
    {



        $equipe = $req->get("Nom");
        $Apps = $req->get('Apps');
        $Minus = $req->get('Minus');
        $Buts = $req->get('Buts');
        $jj=new Joueur();
        $jj->setNom($equipe);

        $j = $em->getRepository(Joueur::class)->findOneBy(['Nom'=>$req->get('Nom')]);




        $per = new PerformanceC();
        $per->setApps($Apps);

        $per->setButs($Buts);
        $per->setJoueurP($j);
        $per->setApps($Apps);
        try {
            $em->persist($per);
            $em->flush();
            return new Response("success");

        } catch (Exception $ex) {
            return new Response("fail");
        }
        return new Response("fail");

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




   /**
     * @Route("/listJoueurs", name="listJoueurs")
     */
public function listJoueurs(SerializerInterface $serializer)
{
    $em = $this->getDoctrine()->getManager();
    $j = $em->getRepository(Joueur::class)->findAll();

    $json = $serializer->serialize($j, 'json', ['groups' => ['joueurs']]);

    var_dump($json);
    return new Response($json);

}
}