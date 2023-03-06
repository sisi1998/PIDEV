<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

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

  

    #[ORM\ManyToOne(inversedBy: 'name')]/'cours'
    #[ORM\JoinColumn(nullable: false)]
    private ?Arena $arenna = null;

    #[ORM\ManyToOne(inversedBy: 'equipex')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Equipe $equipex = null;

    #[ORM\Column(length: 255)]
    private ?string $fullname = null;

  

    public function __construct()
    {
        $this->arenas = new ArrayCollection();
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
            $arena->setArenaName($this);
        }

        return $this;
    }

    public function removeArena(Arena $arena): self
    {
        if ($this->arenas->removeElement($arena)) {
            // set the owning side to null (unless already changed)
            if ($arena->getArenaName() === $this) {
                $arena->setArenaName(null);
            }
        }

        return $this;
    }

    public function getArenna(): ?Arena
    {
        return $this->arenna;
    }

    public function setArenna(?Arena $arenna): self
    {
        $this->arenna = $arenna;

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

    public function getArennnnna(): ?Arena
    {
        return $this->arennnnna;
    }

    public function setArennnnna(?Arena $arennnnna): self
    {
        $this->arennnnna = $arennnnna;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }
}
