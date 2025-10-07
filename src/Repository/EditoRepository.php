<?php

namespace App\Repository;

use App\Entity\Edito;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Edito>
 */
class EditoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Edito::class);
    }
    public function findPublishedTodayOrLater()
    {
        return $this->createQueryBuilder('e')
            ->where('e.datePublication <= :today')
            ->setParameter('today', new \DateTimeImmutable('today'))
            ->orderBy('e.datePublication', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Slider[] Returns an array of Slider objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Slider
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
