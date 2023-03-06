<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Produit;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Ce champ est obligatoire")]
    private ?int $nombreProduit = null;

     #[ORM\Column]
     #[Assert\Positive(message : "Ce champ doit etre > ou = à 0" )]
    private ?int $prixTotal = null;

    #[ORM\ManyToOne(targetEntity: Produit::class)]
    private ?Produit $produit = null;

    

   /* #[ORM\Column]
    private ?float $montant_total = null;
     /**
     * @ORM\Column(type="date")
     */
  /*  #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;*/

    public function __construct()
    {
        $this->article = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Produit>
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Produit $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article->add($article);
        }

        return $this;
    }

    public function removeArticle(Produit $article): self
    {
        $this->article->removeElement($article);

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
