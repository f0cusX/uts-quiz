<?php

namespace App\Repository;

use App\Entity\SearchRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SearchRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method SearchRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method SearchRequest[]    findAll()
 * @method SearchRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SearchRequest::class);
    }
}
