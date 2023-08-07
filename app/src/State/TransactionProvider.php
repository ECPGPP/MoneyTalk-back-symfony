<?php

//typephp hardcore mode
declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\TransactionDto;
use App\Repository\TransactionRepository;

/**
 * @implements ProviderInterface<TransactionDto>.
 */
final class TransactionProvider implements ProviderInterface
{
    public function __construct(
        private readonly TransactionRepository $transactionRepository
    ) {
    }

    /**
     * @param array<mixed> $uriVariables
     * @param array<mixed> $context
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $transactionDto = new TransactionDto();
        if(isset($uriVariables['id'])){
            $id = $uriVariables['id'];
            ['id' => $transactionDto->id, 'createdAt' => $transactionDto->createdAt ] = $this->transactionRepository->getSimpleMPbyId($id);
        }
        return $transactionDto;
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