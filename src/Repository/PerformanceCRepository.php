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


     public function findPLayerByAVG($min,$max){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
            ->createQuery("SELECT s FROM APP\Entity\Student s WHERE s.moyenne BETWEEN :min AND :max")
            ->setParameter('min',$min)
            ->setParameter('max',$max)
            ;
        return $query->getResult();
    }

 public function average($id):int
 {   $qb= $this->createQueryBuilder('per');
     $qb ->where('per.id=:id');
     $qb->setParameter('id', $id);
     $average= intval('per.Apps')*10+intval('per.Mins'*10)+
     intval('per.Buts'*20)+ intval('per.PointsDecivives'*20)
     -intval('per.Jaune'*20)
     -intval('per.Rouge'*10)
     +intval('per.TpM'*10)
     +intval('per.Pr'*10)
     +intval('per.hdM'*10);
    return $average;

 }

 public function orderByButs()
    {
        return $this->createQueryBuilder('per')
            ->orderBy(intval('s.Buts'), 'buts')
            ->getQuery()->getResult();
    }

 public function listStudentByClass($id)
 {
     return $this->createQueryBuilder('s')
         ->join('s.classroom', 'c')
         ->addSelect('c')
         ->where('c.id=:id')
         ->setParameter('id',$id)
         ->getQuery()
         ->getResult();
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
