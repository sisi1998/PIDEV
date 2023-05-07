<?php

namespace App\Repository;
use App\Entity\User;
use App\Entity\PerformanceC;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository; // import the EntityRepository class



/**use Doctrine\ORM\EntityRepository; // import the EntityRepository class

 * @extends ServiceEntityRepository<PerformanceC>
 *
 * @method PerformanceC|null find($id, $lockMode = null, $lockVersion = null)
 * @method PerformanceC|null findOneBy(array $criteria, array $orderBy = null)
 * @method PerformanceC[]    findAll()
 * @method PerformanceC[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PerformanceCRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PerformanceC::class);
    }

    public function save(PerformanceC $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PerformanceC $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByCompetition($competition){

        $qb= $this->createQueryBuilder('p');
        $qb ->where('p.competitionP=:comp');
        $qb->setParameters(['comp'=>$competition]);
        return $qb->getQuery()->getResult();}


        public function findCompetitionsByPlayer($id)
        {
            return $this->createQueryBuilder('p')
                ->select('c')
                ->leftJoin('p.performanceCs', 'pr')
                ->leftJoin('pr.competitionP', 'c')
                ->where('p.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getResult();
        }


 
//  public function orderByButs()
//     {
//         return $this->createQueryBuilder('per')
//             ->orderBy(intval('s.Buts'), 'buts')
//             ->getQuery()->getResult();
//     }

    


//         )
//         ->setParameter('str', '%'.$str.'%')

public function sumButs()
{
    $query = $this->createQueryBuilder('e')
        ->select('SUM(e.Buts)')
        ->where('e.Buts NOT LIKE :zero')
        ->setParameter('zero', '0')
        ->getQuery();

    $result = $query->getSingleScalarResult();

    return $result;
}



public function sumJaune()
{
    $query = $this->createQueryBuilder('e')
        ->select('SUM(e.Jaune)')
        ->where('e.Buts NOT LIKE :zero')
        ->setParameter('zero', '0')
        ->getQuery();

    $result = $query->getSingleScalarResult();

    return $result;
}



public function sumTpM()
{
    $query = $this->createQueryBuilder('e')
        ->select('SUM(e.TpM)')
        ->where('e.Buts NOT LIKE :zero')
        ->setParameter('zero', '0')
        ->getQuery();

    $result = $query->getSingleScalarResult();

    return $result;
}

public function sumRouge()
{
    $query = $this->createQueryBuilder('e')
        ->select('SUM(e.Rouge)')
        ->where('e.Buts NOT LIKE :zero')
        ->setParameter('zero', '0')
        ->getQuery();

    $result = $query->getSingleScalarResult();

    return $result;
}


public function sumPointsDecisives()
{
    $query = $this->createQueryBuilder('e')
        ->select('SUM(e.PointsDecisives)')
        ->where('e.Buts NOT LIKE :zero')
        ->setParameter('zero', '0')
        ->getQuery();

    $result = $query->getSingleScalarResult();

    return $result;
}

public function sumAeriensG()
{ $query = $this->createQueryBuilder('e')
    ->select('SUM(e.AeriensG)')
    ->where('e.Buts NOT LIKE :zero')
    ->setParameter('zero', '0')
    ->getQuery();

$result = $query->getSingleScalarResult();

return $result;
}

public function average($id): array
{
    $qb = $this->createQueryBuilder('per');
    $qb->select(['user.id', 'competition.id', 'AVG(
        (per.Apps * 2) + (per.Mins ) + (per.Buts * 20) + (per.PointsDecisives * 20)
        - (per.Jaune) - (per.Rouge * 2) + (per.TpM) + (per.Pr * 2) + (per.HdM * 2)
    ) as average'])
       ->join('per.joueurP', 'user')
       ->join('per.competitionP', 'competition')
       ->where('user.id = :userId')
       ->groupBy('user.id', 'competition.id')
       ->setParameter('userId', $id);
    
    return $qb->getQuery()->getResult();
}

public function fpc($val)
{
    $entityManager = $this->getEntityManager();
    
    $query = $entityManager->createQuery(
        'SELECT ap
        FROM App\Entity\PerformanceC ap
        JOIN ap.competitionP c
        WHERE c.Nom LIKE :nom'
    )
    ->setParameter('nom', '%'.$val.'%');
    
    return $query->getResult();
}



public function findByPlayerId(int $playerId): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT p
             FROM App\Entity\PerformanceC p
             WHERE p.joueurP = :playerId'
        )->setParameter('playerId', $playerId);

        return $query->getResult();
    }


//    /**
//     * @return PerformanceC[] Returns an array of PerformanceC objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PerformanceC
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
