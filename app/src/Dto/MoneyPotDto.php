<?php

namespace App\Dto;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\State\MoneyPotProvider;

final class MoneyPotDto
{
    final public const DESCRIPTION = 'Retrieve one Money Pot in particular';

    public int $id;
    public \DateTimeImmutable $createdAt;
    public array $transactions;

    // total number of transactions in the MoneyPot
    public int $transactionsNumber = 0;

}