<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $priceFac = null;
    


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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status_stripe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $id_charge_stripe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $last4_stripe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $brand_stripe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $stripe_token = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\ManyToOne(inversedBy: 'factures')]
    private ?CatMembership $mem_id = null;

    #[ORM\ManyToOne(inversedBy: 'factures')]
    private ?User $user = null;

   

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriceFac(): ?float
    {
        return $this->priceFac;
    }

    public function setPriceFac(float $priceFac): self
    {
        $this->priceFac = $priceFac;

        return $this;
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

    public function getStatusStripe(): ?string
    {
        return $this->status_stripe;
    }

    public function setStatusStripe(?string $status_stripe): self
    {
        $this->status_stripe = $status_stripe;

        return $this;
    }

    public function getIdChargeStripe(): ?string
    {
        return $this->id_charge_stripe;
    }

    public function setIdChargeStripe(?string $id_charge_stripe): self
    {
        $this->id_charge_stripe = $id_charge_stripe;

        return $this;
    }

    public function getLast4Stripe(): ?string
    {
        return $this->last4_stripe;
    }

    public function setLast4Stripe(?string $last4_stripe): self
    {
        $this->last4_stripe = $last4_stripe;

        return $this;
    }

    public function getBrandStripe(): ?string
    {
        return $this->brand_stripe;
    }

    public function setBrandStripe(?string $brand_stripe): self
    {
        $this->brand_stripe = $brand_stripe;

        return $this;
    }

    public function getStripeToken(): ?string
    {
        return $this->stripe_token;
    }

    public function setStripeToken(?string $stripe_token): self
    {
        $this->stripe_token = $stripe_token;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getMemId(): ?CatMembership
    {
        return $this->mem_id;
    }

    public function setMemId(?CatMembership $mem_id): self
    {
        $this->mem_id = $mem_id;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

   

    
}
