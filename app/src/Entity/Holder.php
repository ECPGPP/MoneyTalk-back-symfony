<?php

namespace App\Entity;

use App\Repository\HolderRepository;
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
}
