<?php

namespace App\Repository;

use App\Entity\SearchRequest;
use App\Entity\SearchResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SearchResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method SearchResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method SearchResult[]    findAll()
 * @method SearchResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SearchResult::class);
    }

    public function getPage(
        SearchRequest $searchRequest,
        int $page,
        int $pageSize,
        string $orderProperty,
        string $orderDirection
    ): Paginator
    {
        $qb = $this->createQueryBuilder('self');
        switch ($orderProperty) {
            case 'price':
                $orderProperty = 'self.comparePrice';
                break;
            case 'name':
                $qb->join('self.hotel', 'hotel');
                $orderProperty = 'hotel.name';
                break;
            default:
                $orderProperty = 'self.' . $orderProperty;
        }
        $qb
            ->where('self.request = :request')
            ->setParameter('request', $searchRequest)
            ->orderBy($orderProperty, $orderDirection)
        ;
        $paginator = new Paginator($qb, false);
        $paginator
            ->getQuery()
            ->setFirstResult($pageSize * ($page - 1))
            ->setMaxResults($pageSize)
        ;
        return $paginator;
    }
}
