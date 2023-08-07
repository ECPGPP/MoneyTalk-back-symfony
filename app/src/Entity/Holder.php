<?php

namespace App\Entity;

use App\Repository\HolderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\IsNull;

#[ORM\Entity(repositoryClass: HolderRepository::class)]
class Holder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $uniqName = null;

    #[ORM\OneToOne(mappedBy: 'holderReference', cascade: ['persist', 'remove']), IsNull]
    private ?User $referencedUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUniqName(): ?string
    {
        return $this->uniqName;
    }

    public function setUniqName(string $uniqName): static
    {
        $this->uniqName = $uniqName;

        return $this;
    }

    public function getReferencedUser(): ?User
    {
        return $this->referencedUser;
    }

    public function setReferencedUser(User $referencedUser): static
    {
        // set the owning side of the relation if necessary
        if ($referencedUser->getHolderReference() !== $this) {
            $referencedUser->setHolderReference($this);
        }

        $this->referencedUser = $referencedUser;

        return $this;
    }
}
