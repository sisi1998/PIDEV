<?php

namespace App\Repository;

use App\Entity\DISCIPLINE;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DISCIPLINE>
 *
 * @method DISCIPLINE|null find($id, $lockMode = null, $lockVersion = null)
 * @method DISCIPLINE|null findOneBy(array $criteria, array $orderBy = null)
 * @method DISCIPLINE[]    findAll()
 * @method DISCIPLINE[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DISCIPLINERepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DISCIPLINE::class);
    }

    public function save(DISCIPLINE $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DISCIPLINE $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DISCIPLINE[] Returns an array of DISCIPLINE objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DISCIPLINE
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
