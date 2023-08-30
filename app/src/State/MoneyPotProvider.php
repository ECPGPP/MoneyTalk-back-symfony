<?php

//typephp hardcore mode
declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Dto\MoneyPotDto;
use App\Repository\MoneyPotRepository;
use App\Repository\TransactionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use function MongoDB\BSON\toJSON;

/**
 * @implements ProviderInterface<MoneyPotDto>.
 */
final class MoneyPotProvider implements ProviderInterface
{
    public function __construct(
        private readonly MoneyPotRepository $moneyPotRepository,
        private readonly TransactionRepository $transactionRepository
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
            try {
                $fetchedMoneyPot = $this->moneyPotRepository->find($id);
                $moneyPotDto->id = $fetchedMoneyPot->getId();
                $moneyPotDto->createdAt = $fetchedMoneyPot->getCreatedAt();
                $moneyPotDto->transactions = new ArrayCollection($this->transactionRepository->getTransactionsByMPId($id));
                $moneyPotDto->transactions = new ArrayCollection();
                foreach ($this->transactionRepository->getTransactionsByMPId($id) as $entry){
                    $moneyPotDto->transactions->add($entry);
                }
                return new JsonResponse([
                    'id' => $moneyPotDto->id,
                    'transactions' => $moneyPotDto->transactions->toArray(),
                    'createdAt' => $moneyPotDto->createdAt,
                    'message' => $moneyPotDto->dtoMessage
                ]);
            } catch (\Exception $e) {
                return [
                    'message' => 'could not reach ressource',
                    'error' => $e->getMessage()];
            }

        }


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