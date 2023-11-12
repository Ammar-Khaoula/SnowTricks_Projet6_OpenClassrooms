<?php

namespace App\Repository;

use App\Entity\PictureTrick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PictureTrick>
 *
 * @method PictureTrick|null find($id, $lockMode = null, $lockVersion = null)
 * @method PictureTrick|null findOneBy(array $criteria, array $orderBy = null)
 * @method PictureTrick[]    findAll()
 * @method PictureTrick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictureTrickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PictureTrick::class);
    }

}
