<?php

namespace App\Entity;

use App\Repository\LoloRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoloRepository::class)]
class Lolo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomp(): ?string
    {
        return $this->nomp;
    }

    public function setNomp(string $nomp): self
    {
        $this->nomp = $nomp;

        return $this;
    }
}
