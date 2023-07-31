<?php

namespace App\Entity;

use App\Repository\MoneyPotRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoneyPotRepository::class)]
class MoneyPot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'moneyPots')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Holder $owner = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?bool $isShared = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?Holder
    {
        return $this->owner;
    }

    public function setOwner(?Holder $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isIsShared(): ?bool
    {
        return $this->isShared;
    }

    public function setIsShared(bool $isShared): static
    {
        $this->isShared = $isShared;

        return $this;
    }
}
