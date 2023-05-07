<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CatMembershipRepository;

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;



#[ORM\Entity(repositoryClass: CatMembershipRepository::class)]
class CatMembership
{   


    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    
    #[ORM\Column(length: 255)]
    private ?string $name_mem = null;

    #[ORM\Column(length: 255)]
    private ?string $price_mem = null;

    #[ORM\Column(length: 255)]
    private ?string $period_mem = null;

    #[ORM\ManyToOne(inversedBy: 'Memberships',cascade:['persist'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?PromotionsMem $promotion = null;
    

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

    #[ORM\Column(nullable: true)]
    private ?String $description = null;

    #[ORM\OneToMany(mappedBy: 'mem_id', targetEntity: Facture::class)]
    private Collection $factures;

    public function __construct()
    {
        $this->factures = new ArrayCollection();
    }

    
    
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameMem(): ?string
    {
        return $this->name_mem;
    }

    public function setNameMem(string $name_mem): self
    {
        $this->name_mem = $name_mem;

        return $this;
    }

    public function getPriceMem(): ?string
    {
        return $this->price_mem;
    }

    public function setPriceMem(string $price_mem): self
    {
        $this->price_mem = $price_mem;

        return $this;
    }

    public function getPeriodMem(): ?string
    {
        return $this->period_mem;
    }

    public function setPeriodMem(string $period_mem): self
    {
        $this->period_mem = $period_mem;

        return $this;
    }

    public function getPromotion(): ?PromotionsMem
    {
        return $this->promotion;
    }

    public function setPromotion(?PromotionsMem $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }
    public function __toString() {
        if(is_null($this->name_mem)) {
            return 'NULL';
        }
        return $this->name_mem;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
            $facture->setMemId($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getMemId() === $this) {
                $facture->setMemId(null);
            }
        }

        return $this;
    }
    
}
