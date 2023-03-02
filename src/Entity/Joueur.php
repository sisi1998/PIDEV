<?php

namespace App\Entity;

use App\Repository\JoueurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: JoueurRepository::class)]

class Joueur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $DateNaissance = null;

    #[ORM\ManyToOne(inversedBy: 'joueurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Equipe $equipeJ = null;

    #[ORM\OneToMany(mappedBy: 'joueurP', targetEntity: PerformanceC::class)]
    private Collection $performanceCs;

    public function __construct()
    {
        $this->performanceCs = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getDateNaissance(): ?string
    {
        return $this->DateNaissance;
    }

    public function setDateNaissance(string $DateNaissance): self
    {
        $this->DateNaissance = $DateNaissance;

        return $this;
    }

    public function getEquipeJ(): ?Equipe
    {
        return $this->equipeJ;
    }

    public function setEquipeJ(?Equipe $equipeJ): self
    {
        $this->equipeJ = $equipeJ;

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
            $performanceC->setJoueurP($this);
        }

        return $this;
    }

    public function removePerformanceC(PerformanceC $performanceC): self
    {
        if ($this->performanceCs->removeElement($performanceC)) {
            // set the owning side to null (unless already changed)
            if ($performanceC->getJoueurP() === $this) {
                $performanceC->setJoueurP(null);
            }
        }

        return $this;
    }
}
