<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Valreferenceator\Constraints\File;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Service\FileUploader;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface ;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Serializer\Serializer;



#[Route('/produit')]
class ProduitController extends AbstractController
{
    #[Route('/', name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository ): Response
    {

        //vérifier le stock de tous les produits
        // envoi d'un mail en cas de rupture de stock

        $produits = $produitRepository->findAll();
        foreach($produits as $p){
            if($p->getStock() == 0){
                $mail = (new Email())
                    ->from('Ghada.Omri@esprit.tn')
                    ->to('Ghada.Omri@esprit.tn')
                    ->subject('Rupture de stock !')
                    ->html('<h3>Attention !</h3> <br> <h4> Le produit '.$p->getReference().' est en rupture de stock <h4>')
                ;
                $mail->getHeaders()->addTextHeader('X-Auto-Response-Suppress', 'OOF, DR, RN, NRN, AutoReply');
                $transport = Transport::fromDsn('gmail+smtp://Ghada.Omri@esprit.tn:213JFT9290@default?verify_peer=0');
                $mailer = new Mailer($transport);
                try{
                    $mailer->send($mail);
                }catch(TransportExceptionInterface $e){
                    dd($e);
                };

            }
        }

        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
        ]);
    }

    #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProduitRepository $produitRepository, SluggerInterface $slugger): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() )/*&& /*$form->isValreference())*/ {
           
            $image = $form->get('image')->getData();
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'image$imagename' property to store the PDF file name
                // instead of its contents
                $produit->setImage($newFilename);
            }

            // ... persist the $product variable or any other work
             $produitRepository->save($produit, true);
         

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
        /*$serializer = new Serializer([new ObjectNormalizer()]);

        $formateed = £serializer ->normalize($categorie);
        return new JsonResponse($formatted);*/
    }

    #[Route('/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }
    #[Route('a/{id}', name: 'app_produit_showfront', methods: ['GET'])]
    public function show1(Produit $produit): Response
    {
        return $this->render('produit/showfront.html.twig', [
            'produit' => $produit,
        ]);
        /*$serializer = new Serializer([new ObjectNormalizer()]);

        $formateed = £serializer ->normalize($categorie);
        return new JsonResponse($formatted);*/
    }

    #[Route('/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() /*&& $form->isValreference()*/) {
            $produitRepository->save($produit, true);

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
       /* $serializer = new Serializer([new ObjectNormalizer()]);

        $formateed = £serializer ->normalize($categorie);
        return new JsonResponse($formatted);*/
    }

    #[Route('/{id}', name: 'app_produit_delete_old', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        if ($this->isCsrfTokenValreference('delete'.$produit->getreference(), $request->request->get('_token'))) {
            $produitRepository->remove($produit, true);
        }

        return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
    }

      #[Route('/delete/{id}', name: 'app_produit_delete', methods: ['POST'])]
    public function deleteProduit($id, Request $request, ProduitRepository $produitRepository, CommandeRepository $commandeRepository,ManagerRegistry $doctrine)
    {
        $produit = $produitRepository->find($id);
        $commande = $commandeRepository->findBy(array("produit"=>$id));

        $em = $doctrine->getManager(); // $em=$this->getDoctrine()->getManager();
        foreach($commande as $c){
            $em->remove($c);
            $em->flush();
        }
      
        $em = $doctrine->getManager(); // $em=$this->getDoctrine()->getManager();
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute("app_produit_index");
       /* $serializer = new Serializer([new ObjectNormalizer()]);

        $formateed = £serializer ->normalize($categorie);
        return new JsonResponse($formatted);*/
    }
 
  
    


    /*#[Route("/all",name: "list")]
    public function getProduits(ProduitRepository $repo , SerializerInterface $serializer){
        $produits = $repo->findAll();
        //$produitsNormalises = $normalizer->normalize($produits , 'json',['groups' => "produits"]);
       // $json = json_encode($produitsNormalises);
       $json = $serializer->serialize($produits , 'json',['groups' => "produits"]);
        return new Response($json);
    }*/
   /* #[Route("/displayProduit",name: "display_produit")]
    public function allProducts(){
        $produit = $this -> getDoctrine()->getManager()->gerRepository(Produit::class)->findall();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalizer($produit);
         return new JsonResponse($formatted);
    }*/
}
