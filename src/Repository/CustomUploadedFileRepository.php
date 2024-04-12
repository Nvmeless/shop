<?php

namespace App\Repository;

use App\Entity\CustomUploadedFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomUploadedFile>
 *
 * @method CustomUploadedFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomUploadedFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomUploadedFile[]    findAll()
 * @method CustomUploadedFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomUploadedFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomUploadedFile::class);
    }

    //    /**
    //     * @return CustomUploadedFile[] Returns an array of CustomUploadedFile objects
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

    //    public function findOneBySomeField($value): ?CustomUploadedFile
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
