<?php

namespace App\Entity;


use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Dto\TransactionDto;
use App\Repository\TransactionRepository;
use App\State\TransactionProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations:[
        new Get(
            uriTemplate: '/money_pot/{mpid}/transaction/{tid}',
            formats:['json'=>['application/json']],
            description: TransactionDto::DESCRIPTION,
            output: TransactionDto::class,
            provider: TransactionProvider::class,
        ),
        new GetCollection(
            uriTemplate: '/money_pot/{mpid}/transactions',
            formats: ['json'=>['application/json']]
        )
    ],
    normalizationContext: ['groups'=>['id', 'label', 'amount', 'createdAt', 'editedAt']]
)]
#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('id')]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('label')]
    private ?string $label = null;

    #[ORM\Column]
    #[Groups('amount')]
    private ?float $amount = null;

    #[ORM\Column]
    #[Groups('createdAt')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups('editedAt')]
    private ?\DateTimeImmutable $editedAt = null;

    #[ORM\ManyToMany(targetEntity: MoneyPot::class, mappedBy: 'transactions')]
    private Collection $moneyPots;

    #[ORM\ManyToOne(inversedBy: 'transactionsAsAuthor')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[ORM\ManyToOne(inversedBy: 'transactionsAsSender')]
    private ?User $sender = null;

    #[ORM\ManyToOne(inversedBy: 'transactionsAsRecipient')]
    private ?User $recipient = null;

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

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): static
    {
        $this->sender = $sender;

        return $this;
    }

    public function getRecipient(): ?User
    {
        return $this->recipient;
    }

    public function setRecipient(?User $recipient): static
    {
        $this->recipient = $recipient;

        return $this;
    }
}
