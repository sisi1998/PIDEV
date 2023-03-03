<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\CompetitionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



#[UniqueEntity(
    fields :['Date','arena'],
    errorPath: 'Nom',
    message : 'Une competition existe déjà avec cette date et arena')]
 #[ORM\Entity(repositoryClass: CompetitionRepository::class)]
 
class Competition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("competitions")]
    private ?int $id = null;


    #[Groups("competitions")]

    #[Assert\NotBlank(message:"la Date est obligatoire ")]
    #[ORM\Column(length: 255,nullable :true)]
    private ?string $Date = null;


    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Arena $arena = null;

    #[Assert\NotBlank(message:"les equipes sont obligatoires ")]
    #[ORM\JoinColumn(nullable: true)]
    #[ORM\ManyToMany(targetEntity: Equipe::class, inversedBy: 'competitions')]
    private Collection $equipes;

   #[Groups("competitions")]
    #[ORM\Column(length: 255,nullable :true)]
    private ?string $etat = null;




    #[Groups("competitions")]
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Equipe $winner = null;

    


    #[Groups("competitions")]
    #[Assert\NotBlank(message:"le nomest obligatoire ")]
    #[ORM\Column(length: 255,nullable :true)]
    private ?string $Nom = null;


    
    #[ORM\OneToMany(targetEntity: PerformanceC::class, mappedBy: 'competitionP', cascade: [ 'remove'])]
    private Collection $performanceCs;

    

    public function __construct()
    {
        $this->equipes = new ArrayCollection();
        $this->performanceCs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
  

  

    public function getDate(): ?string
    {
        return $this->Date;
    }

    public function setDate(string $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getArena(): ?Arena
    {
        return $this->arena;
    }

    public function setArena(?Arena $arena): self
    {
        $this->arena = $arena;

        return $this;
    }





    /**
     * @return Collection<int, Equipe>
     */
    public function getEquipes(): Collection
    {
        return $this->equipes;
    }


   



    public function addEquipe(Equipe $equipe): self
    {
        if (!$this->equipes->contains($equipe)) {
            $this->equipes->add($equipe);
        }

        return $this;
    }

    public function removeEquipe(Equipe $equipe): self
    {
        $this->equipes->removeElement($equipe);

        return $this;
    }



    


    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getWinner(): ?Equipe
    {
        return $this->winner;
    }

    public function setWinner(?Equipe $winner): self
    {
        $this->winner = $winner;

        return $this;
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

    /**
     * @return Collection<int, PerformanceC>
     */
    public function getPerformanceCs(): Collection
    {
        return $this->performanceCs;
    }

    public function addPerformanceC(PerformanceC $performanceC): self
    {
        if (!$this->performanceCs->contains($performanceC)) {
            $this->performanceCs->add($performanceC);
            $performanceC->setCompetitionP($this);
        }

        return $this;
    }

    public function removePerformanceC(PerformanceC $performanceC): self
    {
        if ($this->performanceCs->removeElement($performanceC)) {
            // set the owning side to null (unless already changed)
            if ($performanceC->getCompetitionP() === $this) {
                $performanceC->setCompetitionP(null);
            }
        }

        return $this;
    }
    


}
