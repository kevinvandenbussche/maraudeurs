<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function selectMedia():QueryBuilder
    {
        $entityManager= $this->getEntityManager();
        $query= $entityManager->createQueryBuilder('a');
            $query
                ->select('a')
                ->from('App\Entity\Article', 'a')
                ->leftJoin('App\Entity\Media','m' )
                ->getQuery()
                ->getResult();

    }
}
