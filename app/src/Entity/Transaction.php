<?php

namespace App\Entity;


use App\Repository\TransactionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $label = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $editedAt = null;

    #[ORM\ManyToMany(targetEntity: MoneyPot::class, mappedBy: 'transactions')]
    private Collection $moneyPots;

    public function __construct()
    {
        $this->moneyPots = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "
        ".strval($this->id)." - 
        ".strval($this->label)." - 
        ".strval($this->amount)." - 
        ".strval($this->createdAt->getTimestamp())."
        ";
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

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

    public function getEditedAt(): ?\DateTimeImmutable
    {
        return $this->editedAt;
    }

    public function setEditedAt(?\DateTimeImmutable $editedAt): static
    {
        $this->editedAt = $editedAt;

        return $this;
    }

    /**
     * @return Collection<int, MoneyPot>
     */
    public function getMoneyPots(): Collection
    {
        return $this->moneyPots;
    }

    public function addMoneyPot(MoneyPot $moneyPot): static
    {
        echo "function addMoneyPot";
        dump($moneyPot);

//        if (!$this->moneyPots->contains($moneyPot)) {

            echo "I PASS ZE IF";

            $this->moneyPots->add($moneyPot);
            $moneyPot->addTransaction($this);
//        }

        return $this;
    }

    public function removeMoneyPot(MoneyPot $moneyPot): static
    {
        if ($this->moneyPots->removeElement($moneyPot)) {
            $moneyPot->removeTransaction($this);
        }

        return $this;
    }
}
