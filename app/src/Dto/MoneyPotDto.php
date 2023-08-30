<?php

namespace App\Dto;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\State\MoneyPotProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class MoneyPotDto
{
    final public const DESCRIPTION = 'MoneyPotDTO : Retrieve one or more Money Pot';

    public int $id;
    public \DateTimeImmutable $createdAt;
    public Collection $transactions;

    //arbitrary parameter
    public string $dtoMessage = self::DESCRIPTION;
    // total number of transactions in the MoneyPot
    //public int $transactionsNumber = 0;

}