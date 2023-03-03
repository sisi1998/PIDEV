<?php

namespace App\Repository;

use App\Entity\PerformanceC;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
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


    public function findByPlayer($player)
    {return $this->createQueryBuilder('per')
    ->where('per.joueurP =: player')
    ->setParameter('player', $player)
    ->getQuery()
    ->getResult();
    }


   
 

 

 public function orderByButs()
    {
        return $this->createQueryBuilder('per')
            ->orderBy(intval('s.Buts'), 'buts')
            ->getQuery()->getResult();
    }

    



 public function rechercheAvance($str) {
    return $this->getEntityManager()
        ->createQuery(
            'SELECT P
            FROM App\Entity\Competition P
            WHERE P.Nom LIKE :str'
        )
        ->setParameter('str', '%'.$str.'%')
        ->getResult();

}
 

public function sumButs()
{
   
    $query = $this->createQueryBuilder('e')
    ->where('e.Buts NOT LIKE :zero')
    ->setParameter('zero', '0')
    ->getQuery();

$result = $query->getResult();
$count = count($result);

return $count;
}


public function sumJaune()
{
    $query = $this->createQueryBuilder('e')
    ->where('e.Jaune NOT LIKE :zero')
    ->setParameter('zero', '0')
    ->getQuery();

$result = $query->getResult();
$count = count($result);


return $count;

}


public function sumRouge()
{
    $query = $this->createQueryBuilder('e')
        ->where('e.Rouge NOT LIKE :zero')
        ->setParameter('zero', '0')
        ->getQuery();

    $result = $query->getResult();
    $count = count($result);
  
    return $count;
}

public function sumPointsDecisives()
{
    $query = $this->createQueryBuilder('e')
        ->where('e.PointsDecisives NOT LIKE :zero')
        ->setParameter('zero', '0')
        ->getQuery();

    $result = $query->getResult();
    $count = count($result);
 
    return $count;
}

public function sumAeriensG()
{
    $query = $this->createQueryBuilder('e')
        ->where('e.AeriensG NOT LIKE :zero')
        ->setParameter('zero', '0')
        ->getQuery();

    $result = $query->getResult();
    $count = count($result);
  
    return $count;
}

public function average($id): array
{   
    $qb = $this->createQueryBuilder('per');
    $qb->select(['joueur.id', 'AVG(
        (per.Apps * 10) + (per.Mins * 10) + (per.Buts * 20) + (per.PointsDecisives * 20)
        - (per.Jaune * 20) - (per.Rouge * 10) + (per.TpM * 10) + (per.Pr * 10) + (per.HdM * 10)
    ) as average'])
       ->join('per.joueurP', 'joueur')
       ->where('joueur.id = :joueurId')
       ->groupBy('joueur.id')
       ->setParameter('joueurId', $id);
       dd($qb->getQuery()->getResult());

    return $qb->getQuery()->getResult();
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
