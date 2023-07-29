<?php

namespace App\Entity;

use App\Repository\HolderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HolderRepository::class)]
class Holder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $UniqName = null;

    #[ORM\ManyToMany(targetEntity: Transaction::class, mappedBy: 'sender')]
    private Collection $transactions;

    #[ORM\OneToMany(mappedBy: 'recipient', targetEntity: Transaction::class)]
    private Collection $author;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->author = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUniqName(): ?string
    {
        return $this->UniqName;
    }

    public function setUniqName(string $UniqName): static
    {
        $this->UniqName = $UniqName;

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
            $transaction->addSender($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): static
    {
        if ($this->transactions->removeElement($transaction)) {
            $transaction->removeSender($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getAuthor(): Collection
    {
        return $this->author;
    }

    public function addAuthor(Transaction $author): static
    {
        if (!$this->author->contains($author)) {
            $this->author->add($author);
            $author->setRecipient($this);
        }

        return $this;
    }

    public function removeAuthor(Transaction $author): static
    {
        if ($this->author->removeElement($author)) {
            // set the owning side to null (unless already changed)
            if ($author->getRecipient() === $this) {
                $author->setRecipient(null);
            }
        }

        return $this;
    }
}
