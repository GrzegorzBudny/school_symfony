<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 *
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    public function add(Student $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Student $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function getAllStudentsfromClass($Class): array
    {
        $qb = $this->createQueryBuilder('s');

        $qb
            ->select('s.name' ,'s.surname', 's.sex','sc.ClassName')
            ->LeftJoin('App\Entity\SchoolClass', 'sc',Join::WITH, 'sc = s.SchoolClass' )
            ->where('sc.ClassName = :value')
            ->setParameter('value', $Class)

        ;

        return $qb->getQuery()->getResult();
    }
    public function get_All_Students_from_Class_Sorted_by_Sex($Class, $Sex): array
    {
        $order_sex = null;
        switch ($Sex)
        {
            case 'M':
                $order_sex = 'DESC';
                break;
            case 'K':
                $order_sex = 'ASC';
                break;
        }
        $qb = $this->createQueryBuilder('s');

        $qb
            ->select('s.name' ,'s.surname', 's.sex','sc.ClassName')
            ->LeftJoin('App\Entity\SchoolClass', 'sc',Join::WITH, 'sc = s.SchoolClass' )
            ->where('sc.ClassName = :value_class')
            ->orderBy('s.sex',$order_sex)
            ->setParameter('value_class', $Class)
        ;

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Student[] Returns an array of Student objects
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

//    public function findOneBySomeField($value): ?Student
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
