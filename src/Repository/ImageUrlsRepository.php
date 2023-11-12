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

}
