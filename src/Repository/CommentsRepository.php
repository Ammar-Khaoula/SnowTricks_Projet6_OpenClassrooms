<?php

namespace App\Repository;

use App\Entity\Comments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comments>
 *
 * @method Comments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comments[]    findAll()
 * @method Comments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comments::class);
    }

    public function findCommentPaginated(int $page, string $slug, int $limit = 3):array
    {
        $limit = abs($limit);
        $result = [];
        $query = $this->getEntityManager()->createQueryBuilder()
                ->select('t', 'c')
                ->from('APP\Entity\Comments', 'c')
                ->join('c.trick', 't')
                ->where("t.slug = '$slug'")
                ->orderBy('c.createdAt' , 'DESC')
                ->setMaxResults($limit)
                ->setFirstResult(($page * $limit) - $limit);

        $paginator = new Paginator($query);
        $data = $paginator->getQuery()->getResult();

        $pages = ceil($paginator->count() / $limit);

        $result['data'] = $data;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['limit'] = $limit;
        
        return $result;
    }

}
