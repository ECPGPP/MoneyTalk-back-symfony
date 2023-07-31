<?php

namespace App\Entity;

use App\Repository\HolderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HolderRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name:'type', type: 'string')]
#[ORM\DiscriminatorMap([
    'user'=>User::class,
    'group'=>Group::class,
])]
class Holder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $uniqName = null;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: MoneyPot::class)]
    private Collection $moneyPots;

    public function __construct()
    {
        $this->moneyPots = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, MoneyPot>
     */
    public function getMoneyPots(): Collection
    {
        return $this->moneyPots;
    }

    public function addMoneyPot(MoneyPot $moneyPot): static
    {
        if (!$this->moneyPots->contains($moneyPot)) {
            $this->moneyPots->add($moneyPot);
            $moneyPot->setOwner($this);
        }

        return $this;
    }

    public function removeMoneyPot(MoneyPot $moneyPot): static
    {
        if ($this->moneyPots->removeElement($moneyPot)) {
            // set the owning side to null (unless already changed)
            if ($moneyPot->getOwner() === $this) {
                $moneyPot->setOwner(null);
            }
        }

        return $this;
    }
}
