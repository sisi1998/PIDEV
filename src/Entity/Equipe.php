<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
#[UniqueEntity(fields: ['Nom'], message: 'nom déjà utilisé')]
#[ORM\Entity(repositoryClass: EquipeRepository::class)]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    
    private ?string $Nom = null;



    #[ORM\Column(type: 'string')]
    private $logo;

    #[ORM\Column]
    #[Assert\Range(min:11,max:30,notInRangeMessage:"le nombre de joueurs doit etre compris entre 11 et 30")]
    private ?int $nb_joueurs = null;
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"ce champ doit ètre rempli ")]
    private ?string $origine = null;

    #[ORM\OneToMany(mappedBy: 'equipeJ', targetEntity: User::class, orphanRemoval: true)]
    private Collection $joueurs;

    #[ORM\ManyToMany(targetEntity: Competition::class, mappedBy: 'equipes', orphanRemoval: true)]
    private Collection $competitions;

    #[ORM\OneToMany(mappedBy: 'equipeJ', targetEntity: User::class)]
    private Collection $yes;

    #[ORM\OneToMany(mappedBy: 'equipeP', targetEntity: User::class)]
    private Collection $jours;

    public function __construct()
    {
        $this->joueurs = new ArrayCollection();
        $this->competitions = new ArrayCollection();
        $this->yes = new ArrayCollection();
        $this->jours = new ArrayCollection();
        $this->cours = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, User>
     */
    public function getJoueurs(): Collection
    {
        return $this->joueurs;
    }

    public function addJoueur(User $joueur): self
    {
        if (!$this->joueurs->contains($joueur)) {
            $this->joueurs->add($joueur);
            $joueur->setEquipeJ($this);
        }

        return $this;
    }

    public function removeJoueur(User $joueur): self
    {
        if ($this->joueurs->removeElement($joueur)) {
            // set the owning side to null (unless already changed)
            if ($joueur->getEquipeJ() === $this) {
                $joueur->setEquipeJ(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Competition>
     */
    public function getCompetitions(): Collection
    {
        return $this->competitions;
    }

    public function addCompetition(Competition $competition): self
    {
        if (!$this->competitions->contains($competition)) {
            $this->competitions->add($competition);
            $competition->addEquipe($this);
        }

        return $this;
    }

    public function removeCompetition(Competition $competition): self
    {
        if ($this->competitions->removeElement($competition)) {
            $competition->removeEquipe($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getYes(): Collection
    {
        return $this->yes;
    }

    public function addYe(User $ye): self
    {
        if (!$this->yes->contains($ye)) {
            $this->yes->add($ye);
            $ye->setEquipeJ($this);
        }

        return $this;
    }

    public function removeYe(User $ye): self
    {
        if ($this->yes->removeElement($ye)) {
            // set the owning side to null (unless already changed)
            if ($ye->getEquipeJ() === $this) {
                $ye->setEquipeJ(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getJours(): Collection
    {
        return $this->jours;
    }

    public function addJour(User $jour): self
    {
        if (!$this->jours->contains($jour)) {
            $this->jours->add($jour);
            $jour->setEquipeP($this);
        }

        return $this;
    }

    public function removeJour(User $jour): self
    {
        if ($this->jours->removeElement($jour)) {
            // set the owning side to null (unless already changed)
            if ($jour->getEquipeP() === $this) {
                $jour->setEquipeP(null);
            }
        }

        return $this;
    }

    public function getNbJoueurs(): ?int
    {
        return $this->nb_joueurs;
    }


    public function setNbJoueurs(int $nb_joueurs): self
    {
        $this->nb_joueurs = $nb_joueurs;

        return $this;
    }
    public function getLogo()
    {
        return $this->logo;
    }

    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }
    public function getOrigine(): ?string
    {
        return $this->origine;
    }

    public function setOrigine(string $origine)
    {
        $this->origine = $origine;

        return $this;
    }
   
    #[ORM\OneToOne(inversedBy: 'equipeP', cascade: ['persist', 'remove'])]
    private ?PerformanceEquipe $performanceE = null;

    #[ORM\OneToMany(mappedBy: 'equipex', targetEntity: Cours::class)]
    private Collection $cours;

   
   

    public function __toString(): string
    {
        return $this->Nom; 

    
}

    public function getPerformanceE(): ?PerformanceEquipe
    {
        return $this->performanceE;
    }

    public function setPerformanceE(?PerformanceEquipe $performanceE): self
    {
        $this->performanceE = $performanceE;

        return $this;
    }

    /**
     * @return Collection<int, Cours>
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): self
    {
        if (!$this->cours->contains($cour)) {
            $this->cours->add($cour);
            $cour->setEquipex($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getEquipex() === $this) {
                $cour->setEquipex(null);
            }
        }

        return $this;
    }
}
