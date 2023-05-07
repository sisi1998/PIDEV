<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Commande;
use App\Entity\Produit;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }


     #[Route('/vetements', name: 'app_vetements')]
    public function AfficherVetement(ProduitRepository $produitRepository): Response
    {
   
         return $this->render('vetements/vetements.html.twig', [
            'vetements' => $produitRepository->findBy(array('categorie' => "1"))
        ]);
    }

    
    #[Route('/nutrition', name: 'app_nutrition')]
    public function AfficherNutrition(ProduitRepository $produitRepository): Response
    {
        return $this->render('nutrition/nutrition.html.twig', [
            'nutritions' => $produitRepository->findBy(array('categorie' => "2"))
        ]);
    }

    
    #[Route('/accessoires', name: 'app_accessoires')]
    public function AfficherAccessoires(ProduitRepository $produitRepository): Response
    {
         return $this->render('accessoires/accessoires.html.twig', [
            'accessoires' => $produitRepository->findBy(array('categorie' => "3"))
        ]);
    }


    #[Route('/passerCommande/{idProduit}/{quantite}', name: 'app_passer_commande')]
    public function passerCommande($idProduit, $quantite, ProduitRepository $produitRepository, CommandeRepository $commandeRepository,ManagerRegistry $doctrine)
    {
        $produit = $produitRepository->find($idProduit);
       

        if($produit->getStock() > 0){

            $commande = new Commande();
            $commande->setPrixTotal($produit->getPrix() * $quantite);
            $commande->setProduit($produit);
            $commande->setNombreProduit($quantite);


            $em = $doctrine->getManager();
            $em->persist($commande);
            $em->flush();

            //mise à jour du stock
            $produit->setStock($produit->getStock() - $quantite);
            $em = $doctrine->getManager();
            $em->flush();

                 $mail = (new Email())
                    ->from('Ghada.Omri@esprit.tn')
                    ->to('Ghada.Omri@esprit.tn')
                    ->subject('Commande passée avec succès !')
                    ->html('<h3>Merci pour votre confiance !</h3> <br>'
                            .'<h4>Récapitulatif de votre commande </h4> <br>'
                            .'Produit : ' . $produit->getReference() .'<br>'
                            .'Prix unitaire : ' . $produit->getPrix() . ' DT <br>'
                            .'Nombre d\'articles : ' . $commande->getNombreProduit(). '<br>'
                            .'Prix total : ' . $commande->getPrixTotal(). ' DT <br>')
                ;
                $mail->getHeaders()->addTextHeader('X-Auto-Response-Suppress', 'OOF, DR, RN, NRN, AutoReply');
                $transport = Transport::fromDsn('gmail+smtp://Ghada.Omri@esprit.tn:213JFT9290@default?verify_peer=0');
                $mailer = new Mailer($transport);
                try{
                    $mailer->send($mail);
                }catch(TransportExceptionInterface $e){
                    dd($e);
                }


        }

      

        return $this->redirectToRoute("app_vetements");
    }
}
