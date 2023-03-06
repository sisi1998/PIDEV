<?php

namespace App\Entity;

use App\Repository\DISCIPLINERepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DISCIPLINERepository::class)]
class DISCIPLINE
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $Note = null;

    #[ORM\Column(length: 1)]
    private ?string $Absence = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?float
    {
        return $this->Note;
    }

    public function setNote(float $Note): self
    {
        $this->Note = $Note;

        return $this;
    }

    public function getAbsence(): ?string
    {
        return $this->Absence;
    }

    public function setAbsence(string $Absence): self
    {
        $this->Absence = $Absence;

        return $this;
    }
}
