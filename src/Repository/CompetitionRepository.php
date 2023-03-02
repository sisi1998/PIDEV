<?php

namespace App\Repository;

use App\Entity\Competition;
use App\Repository\PerformanceCRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\PerformanceC;
/**
 * @extends ServiceEntityRepository<Competition>
 *
 * @method Competition|null find($id, $lockMode = null, $lockVersion = null)
 * @method Competition|null findOneBy(array $criteria, array $orderBy = null)
 * @method Competition[]    findAll()
 * @method Competition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Competition::class);
    }

    public function save(Competition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Competition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function rechercheAvance($str) {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT P
                FROM App\Entity\Competition 
                WHERE P.Nom LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    
    }


   


  
//    /**
//     * @return Competition[] Returns an array of Competition objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

public function findCompetitionFinished(){
    $entityManager=$this->getEntityManager();
    $query=$entityManager
        ->createQuery("SELECT s FROM APP\Entity\Competition s WHERE  LOWER(s.etat) == en cours")
      ;
    return $query->getResult();
}

public function findCompetitionUnFinished(){
    $entityManager=$this->getEntityManager();
    $query=$entityManager
        ->createQuery("SELECT s FROM APP\Entity\Competition s WHERE  LOWER(s.etat) == finished")
      ;
    return $query->getResult();
}

   public function findOneByNom($value): ?Competition
  {
       return $this->createQueryBuilder('c')
            ->andWhere('c.Nom = :val')
            ->setParameter('val', $value)
           ->getQuery()            ->getOneOrNullResult()
        ;
    }


    
 //Recherche :
   //using query builder
  

    public function findBycritere($competition)
    {      
        $this->createQueryBuilder('c')
        ->andWhere('c.Nom LIKE :nom')
        ->orWhere('c.etat LIKE :etat')
        ->orWhere('c.genre LIKE :genre')
        ->setParameter('nom', '%'.$competition->getNom().'%')
        ->setParameter('etat','%'.$competition->getEtat().'%')
        ->setParameter('genre','%'.$competition->getGenre().'%')
        ->getQuery()
        ->execute();
}}
