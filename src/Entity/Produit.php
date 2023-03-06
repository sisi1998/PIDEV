<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use App\Entity\Commande;
use Doctrine\ORM\Mapping as ORM;
use http\Message;
use Symfony\Component\Validator\Constraints as Assert;

use Vich\UploaderBundle\Mapping\Annotation as Vich;


//use App\Entity\var\string; 
//use Symfony\Component\Serializer\Annotation\Groups;
#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: ProduitRepository::class)]

class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    
    private ?int $id = null;

    #[Assert\NotBlank(message:"Ce champ est obligatoire")]
    private ?string $marque = null;

    #[ORM\Column(length: 255)]
    private ?string $genre = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Ce champ est obligatoire")]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

   
   

    /*#[ORM\Column(length: 255)]
    private ?string $image = null;*/

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Ce champ est obligatoire")]
    private ?string $reference = null;


    #[ORM\Column(length:255)]
    #[Assert\NotBlank(message:"Ce champ est obligatoire")]
    //#[Groups("produits")]
    //#[var\string] 
    private $image;



    #[ORM\Column]
    #[Assert\NotBlank(message:"Ce champ est obligatoire")]
    #[Assert\Positive(message : "Ce champ doit etre > ou = à 0" )]
    private ?float $prix = null;

      #[ORM\Column]
      #[Assert\NotBlank(message:"Ce champ est obligatoire")]
    private ?int $stock = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

   public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

  /*public function getImage(): ?string
  {
      return $this->image;
  }

  public function setImage(string $image): self
  {
      $this->image = $image;

      return $this;
  }*/



    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
      public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }
}
