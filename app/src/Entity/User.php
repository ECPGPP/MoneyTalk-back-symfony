<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToOne(inversedBy: 'referencedUser', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Holder $holderReference = null;

    #[ORM\OneToOne(mappedBy: 'owner', cascade: ['persist', 'remove'])]
    private ?MoneyPot $moneyPot = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Transaction::class, orphanRemoval: true)]
    private Collection $transactionsAsAuthor;

    #[ORM\OneToMany(mappedBy: 'sender', targetEntity: Transaction::class)]
    private Collection $transactionsAsSender;

    #[ORM\OneToMany(mappedBy: 'recipient', targetEntity: Transaction::class)]
    private Collection $transactionsAsRecipient;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Token::class, orphanRemoval: true)]
    private Collection $tokens;

    public function __construct()
    {
        $this->transactionsAsAuthor = new ArrayCollection();
        $this->transactionsAsSender = new ArrayCollection();
        $this->transactionsAsRecipient = new ArrayCollection();
        $this->tokens = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        // TODO: Implement __toString() method.
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getHolderReference(): ?Holder
    {
        return $this->holderReference;
    }

    public function setHolderReference(Holder $holderReference): static
    {
        $this->holderReference = $holderReference;

        return $this;
    }

    public function getMoneyPot(): ?MoneyPot
    {
        return $this->moneyPot;
    }

    public function setMoneyPot(?MoneyPot $moneyPot): static
    {
        // unset the owning side of the relation if necessary
        if ($moneyPot === null && $this->moneyPot !== null) {
            $this->moneyPot->setOwner(null);
        }

        // set the owning side of the relation if necessary
        if ($moneyPot !== null && $moneyPot->getOwner() !== $this) {
            $moneyPot->setOwner($this);
        }

        $this->moneyPot = $moneyPot;

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactionsAsAuthor(): Collection
    {
        return $this->transactionsAsAuthor;
    }

    public function addTransactionsAsAuthor(Transaction $transactionsAsAuthor): static
    {
        if (!$this->transactionsAsAuthor->contains($transactionsAsAuthor)) {
            $this->transactionsAsAuthor->add($transactionsAsAuthor);
            $transactionsAsAuthor->setAuthor($this);
        }

        return $this;
    }

    public function removeTransactionsAsAuthor(Transaction $transactionsAsAuthor): static
    {
        if ($this->transactionsAsAuthor->removeElement($transactionsAsAuthor)) {
            // set the owning side to null (unless already changed)
            if ($transactionsAsAuthor->getAuthor() === $this) {
                $transactionsAsAuthor->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactionsAsSender(): Collection
    {
        return $this->transactionsAsSender;
    }

    public function addTransactionsAsSender(Transaction $transactionsAsSender): static
    {
        if (!$this->transactionsAsSender->contains($transactionsAsSender)) {
            $this->transactionsAsSender->add($transactionsAsSender);
            $transactionsAsSender->setSender($this);
        }

        return $this;
    }

    public function removeTransactionsAsSender(Transaction $transactionsAsSender): static
    {
        if ($this->transactionsAsSender->removeElement($transactionsAsSender)) {
            // set the owning side to null (unless already changed)
            if ($transactionsAsSender->getSender() === $this) {
                $transactionsAsSender->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactionsAsRecipient(): Collection
    {
        return $this->transactionsAsRecipient;
    }

    public function addTransactionsAsRecipient(Transaction $transactionsAsRecipient): static
    {
        if (!$this->transactionsAsRecipient->contains($transactionsAsRecipient)) {
            $this->transactionsAsRecipient->add($transactionsAsRecipient);
            $transactionsAsRecipient->setRecipient($this);
        }

        return $this;
    }

    public function removeTransactionsAsRecipient(Transaction $transactionsAsRecipient): static
    {
        if ($this->transactionsAsRecipient->removeElement($transactionsAsRecipient)) {
            // set the owning side to null (unless already changed)
            if ($transactionsAsRecipient->getRecipient() === $this) {
                $transactionsAsRecipient->setRecipient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Token>
     */
    public function getTokens(): Collection
    {
        return $this->tokens;
    }

    public function addToken(Token $token): static
    {
        if (!$this->tokens->contains($token)) {
            $this->tokens->add($token);
            $token->setUser($this);
        }

        return $this;
    }

    public function removeToken(Token $token): static
    {
        if ($this->tokens->removeElement($token)) {
            // set the owning side to null (unless already changed)
            if ($token->getUser() === $this) {
                $token->setUser(null);
            }
        }

        return $this;
    }
}
