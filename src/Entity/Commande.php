<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Produit;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Ce champ est obligatoire")]
    #[Assert\Positive(message : "Ce champ doit etre > ou = à 0" )]
    private ?int $nombreProduit = null;

     #[ORM\Column]
     #[Assert\Positive(message : "Ce champ doit etre > ou = à 0" )]
    private ?int $prixTotal = null;

    #[ORM\ManyToOne(targetEntity: Produit::class)]
    private ?Produit $produit = null;

    


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreProduit(): ?int
    {
        return $this->nombreProduit;
    }

    public function setNombreProduit(int $nombreProduit): self
    {
        $this->nombreProduit = $nombreProduit;

        return $this;
    }

  /*  public function getMontantTotal(): ?float
    {
        return $this->montant_total;
    }

    public function setMontantTotal(float $montant_total): self
    {
        $this->montant_total = $montant_total;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
   */
     public function getPrixTotal(): ?int
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(int $prixTotal): self
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

        public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

}
