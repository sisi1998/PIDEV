<?php

namespace App\Entity;

use App\Repository\ArenaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArenaRepository::class)]
class Arena
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Addresse = null;

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
}
