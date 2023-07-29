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

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $editedAt = null;

    #[ORM\ManyToMany(targetEntity: Holder::class, inversedBy: 'transactions')]
    private Collection $sender;

    #[ORM\ManyToOne(inversedBy: 'author')]
    private ?Holder $recipient = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Holder $author = null;

    public function __construct()
    {
        $this->sender = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
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
     * @return Collection<int, Holder>
     */
    public function getSender(): Collection
    {
        return $this->sender;
    }

    public function addSender(Holder $sender): static
    {
        if (!$this->sender->contains($sender)) {
            $this->sender->add($sender);
        }

        return $this;
    }

    public function removeSender(Holder $sender): static
    {
        $this->sender->removeElement($sender);

        return $this;
    }

    public function getRecipient(): ?Holder
    {
        return $this->recipient;
    }

    public function setRecipient(?Holder $recipient): static
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getAuthor(): ?Holder
    {
        return $this->author;
    }

    public function setAuthor(?Holder $author): static
    {
        $this->author = $author;

        return $this;
    }
}
