<?php

namespace App\Repository;

use App\Entity\Personne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Personne>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personne::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return User[] Returns an array of Personne objects
     */
    public function finduserByAgeInterval($ageMin, $ageMax): array
    {
        $qb = $this->createQueryBuilder('u');
        $this->addIntervalAge($qb,$ageMin,$ageMax);

        return  $qb->getQuery()->getResult();
    }


    /**
     * @return User[] Returns an array of Personne objects
     */
    public function statsUserByAgeInterval($ageMin, $ageMax): array
    {
        $qb =  $this->createQueryBuilder('u')->select('avg(u.age) as ageMoyen, count(u.id) as nbrUsers');

        $this->addIntervalAge($qb,$ageMin, $ageMax);

       return $qb->getQuery()->getScalarResult();
    }

    private function addIntervalAge(QueryBuilder $qb, $ageMin, $ageMax)
    {
        $qb->andWhere('u.age >= :ageMin and u.age <= :ageMax')
            ->setParameters(['ageMin' => $ageMin , 'ageMax'=> $ageMax]);
    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
