<?php

namespace App\Entity;

use App\Repository\MLOLORepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MLOLORepository::class)]
class MLOLO
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NAME = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNAME(): ?string
    {
        return $this->NAME;
    }

    public function setNAME(string $NAME): self
    {
        $this->NAME = $NAME;

        return $this;
    }
}
