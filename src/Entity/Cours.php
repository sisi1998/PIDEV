<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[Assert\NotBlank(message:"Nom is required")]
    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank(message:"seance is required")]

    private ?\DateTimeInterface $seance = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"seance is required")]
    private ?int $duree = null;

  


    #[ORM\ManyToOne(inversedBy: 'cours')]
    private ?Arena $arenaC = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    private ?Equipe $equipex = null;

   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getSeance(): ?\DateTimeInterface
    {
        return $this->seance;
    }

    public function setSeance(\DateTimeInterface $seance): self
    {
        $this->seance = $seance;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getArenaC(): ?Arena
    {
        return $this->arenaC;
    }

    public function setArenaC(?Arena $arenaC): self
    {
        $this->arenaC = $arenaC;

        return $this;
    }

    public function getEquipex(): ?Equipe
    {
        return $this->equipex;
    }

    public function setEquipex(?Equipe $equipex): self
    {
        $this->equipex = $equipex;

        return $this;
    }

  
   

   






}
