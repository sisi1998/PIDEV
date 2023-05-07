<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PromotionsMemRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: PromotionsMemRepository::class)]
class PromotionsMem
{   

   
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    

    #[ORM\Column]
    private ?float $percentageprom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $periodpro = null;

    #[ORM\OneToMany(mappedBy: 'promotion', targetEntity: CatMembership::class, orphanRemoval: true)]
    private Collection $Memberships;

    #[ORM\Column(length: 255)]
    private ?string $name_promo = null;
    


    /**
    * @Gedmo\Timestampable(on="create")
    */
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;
    /**
     * @Gedmo\Timestampable(on="update")
     */
    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->Memberships = new ArrayCollection();
    }
   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPercentageprom(): ?float
    {
        return $this->percentageprom;
    }

    public function setPercentageprom(float $percentageprom): self
    {
        $this->percentageprom = $percentageprom;

        return $this;
    }

    public function getPeriodpro(): ?\DateTimeInterface
    {
        return $this->periodpro;
    }

    public function setPeriodpro(\DateTimeInterface $periodpro): self
    {
        $this->periodpro = $periodpro;

        return $this;
    }

    /**
     * @return Collection<int, CatMembership>
     */
    public function getMemberships(): Collection
    {
        return $this->Memberships;
    }

    public function addMembership(CatMembership $membership): self
    {
        if (!$this->Memberships->contains($membership)) {
            $this->Memberships->add($membership);
            $membership->setPromotion($this);
        }

        return $this;
    }

    public function removeMembership(CatMembership $membership): self
    {
        if ($this->Memberships->removeElement($membership)) {
            // set the owning side to null (unless already changed)
            if ($membership->getPromotion() === $this) {
                $membership->setPromotion(null);
            }
        }

        return $this;
    }

    public function getNamePromo(): ?string
    {
        return $this->name_promo;
    }

    public function setNamePromo(string $name_promo): self
    {
        $this->name_promo = $name_promo;

        return $this;
    }
    public function __toString() {
        return $this->Memberships;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    
   
}
