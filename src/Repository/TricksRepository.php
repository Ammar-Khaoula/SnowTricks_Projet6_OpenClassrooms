<?php

namespace App\Repository;

use App\Entity\Tricks;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Tricks>
 *
 * @method Tricks|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tricks|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tricks[]    findAll()
 * @method Tricks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TricksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tricks::class);
    }
    public function findTricksPaginated(int $page, int $limit = 3):array
    {
        $limit = abs($limit);
        $result = [];
        $query = $this->getEntityManager()->createQueryBuilder()
                ->select('t')
                ->from('APP\Entity\Tricks', 't')
                ->orderBy('t.createdAt' , 'DESC')
                ->setMaxResults($limit)
                ->setFirstResult(($page * $limit) - $limit);

        $paginator = new Paginator($query);
        $data = $paginator->getQuery()->getResult();

        if(empty($data)){
            return $result;
        }
        $pages = ceil($paginator->count() / $limit);

        $result['data'] = $data;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['limit'] = $limit;
        
        return $result;
    }
}
