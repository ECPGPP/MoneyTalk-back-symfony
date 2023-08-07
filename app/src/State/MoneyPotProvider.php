<?php

//typephp hardcore mode
declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\MoneyPotDto;
use App\Repository\MoneyPotRepository;

/**
 * @implements ProviderInterface<MoneyPotDto>.
 */
final class MoneyPotProvider implements ProviderInterface
{
    public function __construct(
        private readonly MoneyPotRepository $moneyPotRepository
    ) {
    }

    /**
     * @param array<mixed> $uriVariables
     * @param array<mixed> $context
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $moneyPotDto = new MoneyPotDto();
        if(isset($uriVariables['id'])){
            $id = $uriVariables['id'];
            ['id' => $moneyPotDto->id, 'createdAt' => $moneyPotDto->createdAt ] = $this->moneyPotRepository->getSimpleMPbyId($id);
        }
        return $moneyPotDto;
    }
}


/**
public function __construct(MoneyPot $moneyPot)
{
$this->id = $moneyPot->getId();
$this->createdAt = $moneyPot->getCreatedAt();
$this->transactions = $moneyPot->getTransactions()->toArray();
}
public function getId(): ?int
{
return $this->id;
}
public function getCreatedAt(): ?\DateTimeImmutable
{
return $this->createdAt;
}
public function getTransactions(): ?array
{
return $this->transactions;
}
**/