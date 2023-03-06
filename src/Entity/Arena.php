<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ArenaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: ArenaRepository::class)]
class Arena 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    
    private ?int $id = null;

    #[Assert\NotBlank(message:"TERRAIN is required")]
    #[ORM\Column(length: 255)]
    private ?string $TERRAIN = null;
    #[Assert\NotBlank(message:"surface is required")]
    #[ORM\Column(length: 255)]
    private ?string $surface = null;

    //#[ORM\OneToMany(mappedBy: 'arena', targetEntity: Equipe::class)]
   // private Collection $Nom_Equipe;

   // #[ORM\ManyToOne(inversedBy: 'arenas')]
   // private ?Equipe $Nom = null;


   // #[ORM\OneToMany(mappedBy: 'arenna', targetEntity: Cours::class)]
   // private Collection $name;

   

   #[ORM\OneToMany(mappedBy: 'arennnnna', targetEntity: Cours::class)]
    private Collection $arennnnna;

    public function __construct()
    {
        $this->Nom_Equipe = new ArrayCollection();
        $this->name = new ArrayCollection();
        $this->equipename = new ArrayCollection();
        $this->arennnnna = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTERRAIN(): ?string
    {
        return $this->TERRAIN;
    }

    public function setTERRAIN(string $TERRAIN): self
    {
        $this->TERRAIN = $TERRAIN;

        return $this;
    }

    public function getSurface(): ?string
    {
        return $this->surface;
    }

    public function setSurface(string $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    /*/**
     * @return Collection<int, Equipe>
     */
    public function getNomEquipe(): Collection
    {
        return $this->Nom_Equipe;
    }

    public function addNomEquipe(Equipe $nomEquipe): self
    {
        if (!$this->Nom_Equipe->contains($nomEquipe)) {
            $this->Nom_Equipe->add($nomEquipe);
            $nomEquipe->setArena($this);
        }

        return $this;
    }

    public function removeNomEquipe(Equipe $nomEquipe): self
    {
        if ($this->Nom_Equipe->removeElement($nomEquipe)) {
            // set the owning side to null (unless already changed)
            if ($nomEquipe->getArena() === $this) {
                $nomEquipe->setArena(null);
            }
        }

        return $this;
    }

    public function getNom(): ?Equipe
    {
        return $this->Nom;
    }

    public function setNom(?Equipe $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getArenaName(): ?Cours
    {
        return $this->ArenaName;
    }

    public function setArenaName(?Cours $ArenaName): self
    {
        $this->ArenaName = $ArenaName;

        return $this;
    }

    /**
     * @return Collection<int, Cours>
     */
    public function getName(): Collection
    {
        return $this->name;
    }

    public function addName(Cours $name): self
    {
        if (!$this->name->contains($name)) {
            $this->name->add($name);
            $name->setArenna($this);
        }

        return $this;
    }

    public function removeName(Cours $name): self
    {
        if ($this->name->removeElement($name)) {
            // set the owning side to null (unless already changed)
            if ($name->getArenna() === $this) {
                $name->setArenna(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Equipe>
     */
    public function getEquipename(): Collection
    {
        return $this->equipename;
    }

    public function addEquipename(Equipe $equipename): self
    {
        if (!$this->equipename->contains($equipename)) {
            $this->equipename->add($equipename);
            $equipename->setAx($this);
        }

        return $this;
    }

    public function removeEquipename(Equipe $equipename): self
    {
        if ($this->equipename->removeElement($equipename)) {
            // set the owning side to null (unless already changed)
            if ($equipename->getAx() === $this) {
                $equipename->setAx(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cours>
     */
    public function getArennnnna(): Collection
    {
        return $this->arennnnna;
    }

    public function addArennnnna(Cours $arennnnna): self
    {
        if (!$this->arennnnna->contains($arennnnna)) {
            $this->arennnnna->add($arennnnna);
            $arennnnna->setArennnnna($this);
        }

        return $this;
    }

    public function removeArennnnna(Cours $arennnnna): self
    {
        if ($this->arennnnna->removeElement($arennnnna)) {
            // set the owning side to null (unless already changed)
            if ($arennnnna->getArennnnna() === $this) {
                $arennnnna->setArennnnna(null);
            }
        }

        return $this;
    }
}
