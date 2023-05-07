<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;



#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'cet Email est déjà utilisé !')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("user")]
    private ?int $id = null;

    #[Groups("user")]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email(message: "L'email '{{ value }}' n'est pas valide !.")]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 6, minMessage: "le mot de passe est trés courte (6 caractéres au moins)")]
    private ?string $mdp = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_birth = null;

    #[ORM\Column]
    private ?bool $isBlocked = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $resetToken = null;

    #[ORM\ManyToOne(inversedBy: 'yes')]
    private ?Equipe $equipeJ = null;


  
   // #[Ignore()]
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: PerformanceC::class)]
    private Collection $performanceCs;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Facture::class)]
    private Collection $factures;

    #[ORM\ManyToOne(inversedBy: 'jours')]
    private ?Equipe $equipeP = null;

    public function __construct()
    {
        $this->performanceCs = new ArrayCollection();
        $this->factures = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }
    //___________Block_cryptage______________

    public function encodePassword(PasswordEncoderInterface $encoder, String $password): void
    {
        $this->mdp = $encoder->encodePassword($password, "2y");
    }
    public function isValid(String $encoded, PasswordEncoderInterface $encoder): bool
    {
        return $encoder->isPasswordValid($this->mdp, $encoded, "2y");
    }

    //___________Block_cryptage______________

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getDateBirth(): ?\DateTimeInterface
    {
        return $this->date_birth;
    }

    public function setDateBirth(\DateTimeInterface $date_birth): self
    {
        $this->date_birth = $date_birth;

        return $this;
    }

    public function isIsBlocked(): ?bool
    {
        return $this->isBlocked;
    }

    public function setIsBlocked(bool $isBlocked): self
    {
        $this->isBlocked = $isBlocked;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(string $resetToken): self
    {
        $this->resetToken = $resetToken;

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
            $performanceC->setUser($this);
        }

        return $this;
    }

    public function removePerformanceC(PerformanceC $performanceC): self
    {
        if ($this->performanceCs->removeElement($performanceC)) {
            // set the owning side to null (unless already changed)
            if ($performanceC->getUser() === $this) {
                $performanceC->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Facture>
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): self
    {
        if (!$this->factures->contains($facture)) {
            $this->factures->add($facture);
            $facture->setUser($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getUser() === $this) {
                $facture->setUser(null);
            }
        }

        return $this;
    }

    public function getEquipeP(): ?Equipe
    {
        return $this->equipeP;
    }

    public function setEquipeP(?Equipe $equipeP): self
    {
        $this->equipeP = $equipeP;

        return $this;
    }

   
}
