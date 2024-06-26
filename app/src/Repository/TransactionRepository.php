<?php

namespace App\Repository;

use App\Entity\MoneyPot;
use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Transaction>
 *
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    public function save(Transaction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Transaction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function test($id){
        return $this->createQueryBuilder('t')
            ->join('t.moneyPots', 'm')
            ->andWhere('m.id = :val')
            ->setParameter('val', $id)
            ->addSelect()
            ->getQuery()
            ->getResult()
        ;
    }

    public function getTransactionsByMPId($id){
        $em = $this->getEntityManager();
        $query = $em->createQuery(
          'SELECT t.id, t.label, t.amount, t.createdAt
          FROM App\Entity\Transaction t
          INNER JOIN t.moneyPots m
          WHERE m.id = :id'
        )->setParameter('id', $id);
        return $query->getResult();
    }

//    /**
//     * @return Transaction[] Returns an array of Transaction objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Transaction
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

/**
    public function findByMoneyPotId($moneyPotId)
    {

        //TODO

        SELECT * FROM transaction JOIN money_pot_transaction mpt on transaction.id = mpt.transaction_id;

        $entityManager = $this->getEntityManager();

        return $this->createQuery(
            'SELECT '
        );


        return $this->createQueryBuilder();

    }
**/
}
