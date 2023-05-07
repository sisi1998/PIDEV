<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use App\Repository\PerformanceCRepository;
use Doctrine\ORM\Mapping as ORM;

use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;



#[UniqueEntity(
    fields :['joueurP','competitionP'],
    errorPath: 'joueurP',
    message : 'Une performance existe déjà avec cette date et arena')]
#[ORM\Entity(repositoryClass: PerformanceCRepository::class)]

class PerformanceC
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("perfs")]
    private ?int $id = null;


    #[Groups("perfs")]
    #[ORM\ManyToOne(inversedBy: 'performanceCs')]
    private ?User $joueurP = null;

    #[Groups("perfs")]
    #[ORM\ManyToOne(inversedBy: 'performanceCs')]
    private ?Competition $competitionP = null;

  /**
     * @Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     message="The value {{ value }} is not a valid integer."
     * )
     */
    #[Groups("perfs")]
    #[Assert\Regex(pattern:"/^[0-9]+$/",message:" ")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Apps = null;

    #[Groups("perfs")]
    #[Assert\Regex(pattern:"/^[0-9]+$/",message:" Entree invalide ")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Mins = null;

    #[Groups("perfs")]
    #[Assert\Regex(pattern:"/^[0-9]+$/",message:" Entree invalide ")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Buts = null;


    #[Assert\Regex(pattern:"/^[0-9]+$/",message:" Entree invalide ")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PointsDecisives = null;


    #[Assert\Regex(pattern:"/^[0-9]+$/",message:" Entree invalide ")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Jaune = null;


    #[Assert\Regex(pattern:"/^[0-9]+$/",message:" Entree invalide ")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Rouge = null;

    #[Assert\Regex(pattern:"/^[0-9]+$/",message:" Entree invalide ")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $TpM = null;

    #[Assert\Regex(pattern:"/^[0-9]+$/",message:" Entree invalide ")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Pr = null;

    #[Assert\Regex(pattern:"/^[0-9]+$/",message:" Entree invalide ")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $AeriensG = null;

    #[Assert\Regex(pattern:"/^[0-9]+$/",message:" Entree invalide ")]
    #[ORM\Column(length: 255, nullable: true)]
private ?string $HdM = null;

#[Assert\Regex(pattern:"/^[0-9]+$/",message:" Entree invalide ")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Note = null;

#[ORM\ManyToOne(inversedBy: 'performanceCs')]
private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJoueurP(): ?User
    {
        return $this->joueurP;
    }

    public function setJoueurP(?User $joueurP): self
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
