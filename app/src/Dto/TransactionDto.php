<?php

namespace App\Dto;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\State\MoneyPotProvider;

final class TransactionDto
{
    final public const DESCRIPTION = 'Retrieve one Transaction in particular';

    public int $id;
    public string $label;
    public float $amount;
    public \DateTimeImmutable $createdAt;
    public \DateTimeImmutable $editedAt;


}