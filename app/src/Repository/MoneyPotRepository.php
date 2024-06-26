<?php

namespace App\Repository;

use App\Entity\MoneyPot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MoneyPot>
 *
 * @method MoneyPot|null find($id, $lockMode = null, $lockVersion = null)
 * @method MoneyPot|null findOneBy(array $criteria, array $orderBy = null)
 * @method MoneyPot[]    findAll()
 * @method MoneyPot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoneyPotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MoneyPot::class);
    }

    public function save(MoneyPot $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MoneyPot $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getSimpleMPbyId(int $id): array{
        $moneyPot = $this->find($id);
        if(!isset($moneyPot)){
            return [];
        }
        return [
            'id' => $moneyPot->getId(),
            'createdAt' => $moneyPot->getCreatedAt()
        ];
    }

// TODO retourner les transactions d'un moneypot avec ce PUTAIN de querybuilder

/**TERRIBLE WIP
    public function findTransactionsByMoneyPotId(int $id){
        return $this->createQueryBuilder('m')
            ->join('m.id', 'id')
            ->addSelect('id')
            ->getQuery()
            ->getResult()
        ;
    }
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
$query = 'select * from MyBundle\Entity\Alpha alpha where alpha.id = :something';
return $this->getEntityManager()
->createQuery($query)
->setParameter('something', $something)
->getResult();

//      @return MoneyPot[] Returns an array of MoneyPot objects
//
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MoneyPot
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

TERRIBLE WIP **/

}
