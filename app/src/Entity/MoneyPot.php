<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Dto\MoneyPotDto;
use App\Repository\MoneyPotRepository;
use App\State\MoneyPotProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/money_pot/{id}',
            formats: ['json'=>['application/json']],
            uriVariables: ['id'=> 'id'],
            description: MoneyPotDto::DESCRIPTION,
            output: MoneyPotDto::class,
            provider: MoneyPotProvider::class
        ),
        new GetCollection(
            uriTemplate: '/money_pots'
        )
    ]
)]

#[ORM\Entity(repositoryClass: MoneyPotRepository::class)]
class MoneyPot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?bool $isShared = null;

    #[ORM\ManyToMany(targetEntity: Transaction::class, inversedBy: 'moneyPots')]
    private Collection $transactions;

    #[ORM\OneToOne(inversedBy: 'moneyPot', cascade: ['persist', 'remove'])]
    private ?User $owner = null;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }
    public function __toString(): string
    {
        $data = [
            'id'=> $this->id,
            'createdAt'=>$this->createdAt,
            'isShared'=>$this->isShared,
        ];

        return strval(json_encode($data));
    }

    public function getHello(){
        return "OLA!";
    }


    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): static
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        $this->transactions->removeElement($transaction);

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }
}
