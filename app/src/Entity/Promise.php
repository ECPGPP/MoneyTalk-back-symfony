<?php

namespace App\Entity;

use App\Repository\PromiseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromiseRepository::class)]
class Promise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $plannedDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlannedDate(): ?\DateTimeImmutable
    {
        return $this->plannedDate;
    }

    public function setPlannedDate(?\DateTimeImmutable $plannedDate): static
    {
        $this->plannedDate = $plannedDate;

        return $this;
    }
}
