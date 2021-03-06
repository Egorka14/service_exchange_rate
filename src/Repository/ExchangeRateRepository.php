<?php

namespace App\Repository;

use App\Entity\ExchangeRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ExchangeRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExchangeRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExchangeRate[]    findAll()
 * @method ExchangeRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExchangeRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExchangeRate::class);
    }

    // /**
    //  * @return ExchangeRate[] Returns an array of ExchangeRate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function getByCurrency()
    {
        return $this->createQueryBuilder('e')
            ->getQuery()
            ->getResult()
            ;
    }

    public function deleteCurrency()
    {
        return $this->createQueryBuilder('e')
            ->delete()
            ->getQuery()
            ->getResult()
            ;
    }

//    public function getByCurrency($date)
//    {
//        $qb = $this->createQueryBuilder();
//        $query = $qb->select('t')
//            ->from('App\Entity\ExchangeRate', 't')
//            ->where('t.dateCurrency = :from')
//            ->setParameter('from', $date->format('Y-m-d 00:00:00'))
//            ->getQuery();
//
//        return $query->getResult();
//    }

    /*
    public function findOneBySomeField($value): ?ExchangeRate
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
