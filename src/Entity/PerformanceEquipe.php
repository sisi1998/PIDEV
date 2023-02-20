<?php

namespace App\Entity;

use App\Repository\PerformanceEquipeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PerformanceEquipeRepository::class)]
class PerformanceEquipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nom_performance = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'date_mise_a_jour')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Equipe $Equipe_Responsable = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_mise_a_jour = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPerformance(): ?int
    {
        return $this->nom_performance;
    }

    public function setNomPerformance(int $nom_performance): self
    {
        $this->nom_performance = $nom_performance;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEquipeResponsable(): ?Equipe
    {
        return $this->Equipe_Responsable;
    }

    public function setEquipeResponsable(?Equipe $Equipe_Responsable): self
    {
        $this->Equipe_Responsable = $Equipe_Responsable;

        return $this;
    }

    public function getDateMiseAJour(): ?\DateTimeInterface
    {
        return $this->date_mise_a_jour;
    }

    public function setDateMiseAJour(\DateTimeInterface $date_mise_a_jour): self
    {
        $this->date_mise_a_jour = $date_mise_a_jour;

        return $this;
    }
}
