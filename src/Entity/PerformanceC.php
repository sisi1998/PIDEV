<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use App\Repository\PerformanceCRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Joueur;



#[UniqueEntity(
    fields :['joueurP','competitionP'],
    errorPath: 'joeurP',
    message : 'Une performance existe déjà avec cette date et arena')]
#[ORM\Entity(repositoryClass: PerformanceCRepository::class)]

class PerformanceC
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'performanceCs')]
    private ?joueur $joueurP = null;

    #[ORM\ManyToOne(inversedBy: 'performanceCs')]
    private ?Competition $competitionP = null;


    #[Assert\NotBlank(message:"ce champ est obligatoire ")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Apps = null;

    #[Assert\NotBlank(message:"ce champ est obligatoire ")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Mins = null;


    #[Assert\NotBlank(message:"ce champ est obligatoire ")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Buts = null;


    #[Assert\NotBlank(message:"ce champ est obligatoire ")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PointsDecisives = null;


    #[Assert\NotBlank(message:"ce champ est obligatoire ")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Jaune = null;


    #[Assert\NotBlank(message:"ce champ est obligatoire ")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Rouge = null;

    #[Assert\NotBlank(message:"ce champ est obligatoire ")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $TpM = null;

 #[Assert\NotBlank(message:"ce champ est obligatoire ")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Pr = null;

    #[Assert\NotBlank(message:"ce champ est obligatoire ")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $AeriensG = null;

    #[Assert\NotBlank(message:"ce champ est obligatoire ")]
    #[ORM\Column(length: 255, nullable: true)]
private ?string $HdM = null;

    #[Assert\NotBlank(message:"ce champ est obligatoire ")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Note = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJoueurP(): ?Joueur
    {
        return $this->joueurP;
    }

    public function setJoueurP(?Joueur $joueurP): self
    {
        $this->joueurP = $joueurP;

        return $this;
    }

    public function getCompetitionP(): ?Competition
    {
        return $this->competitionP;
    }

    public function setCompetitionP(?Competition $competitionP): self
    {
        $this->competitionP = $competitionP;

        return $this;
    }

    public function getApps(): ?string
    {
        return $this->Apps;
    }

    public function setApps(?string $Apps): self
    {
        $this->Apps = $Apps;

        return $this;
    }

    public function getMins(): ?string
    {
        return $this->Mins;
    }

    public function setMins(?string $Mins): self
    {
        $this->Mins = $Mins;

        return $this;
    }

    public function getButs(): ?string
    {
        return $this->Buts;
    }

    public function setButs(?string $Buts): self
    {
        $this->Buts = $Buts;

        return $this;
    }

    public function getPointsDecisives(): ?string
    {
        return $this->PointsDecisives;
    }

    public function setPointsDecisives(?string $PointsDecisives): self
    {
        $this->PointsDecisives = $PointsDecisives;

        return $this;
    }

    public function getJaune(): ?string
    {
        return $this->Jaune;
    }

    public function setJaune(?string $Jaune): self
    {
        $this->Jaune = $Jaune;

        return $this;
    }

    public function getRouge(): ?string
    {
        return $this->Rouge;
    }

    public function setRouge(?string $Rouge): self
    {
        $this->Rouge = $Rouge;

        return $this;
    }

    public function getTpM(): ?string
    {
        return $this->TpM;
    }

    public function setTpM(?string $TpM): self
    {
        $this->TpM = $TpM;

        return $this;
    }

    public function getPr(): ?string
    {
        return $this->Pr;
    }

    public function setPr(?string $Pr): self
    {
        $this->Pr = $Pr;

        return $this;
    }

    public function getAeriensG(): ?string
    {
        return $this->AeriensG;
    }

    public function setAeriensG(?string $AeriensG): self
    {
        $this->AeriensG = $AeriensG;

        return $this;
    }

    public function getHdM(): ?string
    {
        return $this->HdM;
    }

    public function setHdM(?string $HdM): self
    {
        $this->HdM = $HdM;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->Note;
    }

    public function setNote(?string $Note): self
    {
        $this->Note = $Note;

        return $this;
    }
}
