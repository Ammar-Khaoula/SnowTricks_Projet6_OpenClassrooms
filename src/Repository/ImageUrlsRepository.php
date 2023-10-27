<?php

namespace App\Repository;

use App\Entity\ImageUrls;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImageUrls>
 *
 * @method ImageUrls|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageUrls|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageUrls[]    findAll()
 * @method ImageUrls[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageUrlsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageUrls::class);
    }

//    /**
//     * @return ImageUrls[] Returns an array of ImageUrls objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ImageUrls
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
