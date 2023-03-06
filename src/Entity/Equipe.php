<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'Nom_Equipe')]
    private ?Arena $arena = null;

    #[ORM\OneToMany(mappedBy: 'Nom', targetEntity: Arena::class)]
    private Collection $arenas;

    

    #[ORM\OneToMany(mappedBy: 'equipex', targetEntity: Cours::class)]
    private Collection $equipex;

    public function __construct()
    {
        $this->arenas = new ArrayCollection();
        $this->equipex = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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
     * @return Collection<int, Arena>
     */
    public function getArenas(): Collection
    {
        return $this->arenas;
    }

    public function addArena(Arena $arena): self
    {
        if (!$this->arenas->contains($arena)) {
            $this->arenas->add($arena);
            $arena->setNom($this);
        }

        return $this;
    }

    public function removeArena(Arena $arena): self
    {
        if ($this->arenas->removeElement($arena)) {
            // set the owning side to null (unless already changed)
            if ($arena->getNom() === $this) {
                $arena->setNom(null);
            }
        }

        return $this;
    }

    public function getAx(): ?Arena
    {
        return $this->Ax;
    }

    public function setAx(?Arena $Ax): self
    {
        $this->Ax = $Ax;

        return $this;
    }

    /**
     * @return Collection<int, Cours>
     */
    public function getEquipex(): Collection
    {
        return $this->equipex;
    }

    public function addEquipex(Cours $equipex): self
    {
        if (!$this->equipex->contains($equipex)) {
            $this->equipex->add($equipex);
            $equipex->setEquipex($this);
        }

        return $this;
    }

    public function removeEquipex(Cours $equipex): self
    {
        if ($this->equipex->removeElement($equipex)) {
            // set the owning side to null (unless already changed)
            if ($equipex->getEquipex() === $this) {
                $equipex->setEquipex(null);
            }
        }

        return $this;
    }
}
