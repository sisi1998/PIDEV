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


    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Addresse = null;

    #[ORM\OneToMany(mappedBy: 'arenaC', targetEntity: Cours::class)]
    private Collection $cours;

    public function __construct()
    {
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

    public function getAddresse(): ?string
    {
        return $this->Addresse;
    }

    public function setAddresse(string $Addresse): self
    {
        $this->Addresse = $Addresse;

        return $this;
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
            $cour->setArenaC($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getArenaC() === $this) {
                $cour->setArenaC(null);
            }
        }

        return $this;
    }
}
