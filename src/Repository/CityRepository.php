<?php

namespace App\Repository;

use App\Entity\City;
use App\Entity\Country;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method City|null find($id, $lockMode = null, $lockVersion = null)
 * @method City|null findOneBy(array $criteria, array $orderBy = null)
 * @method City[]    findAll()
 * @method City[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, City::class);
    }

    public function getPage(
        Country $country,
        int $page,
        int $pageSize,
        string $orderProperty,
        string $orderDirection
    ): Paginator
    {
        $qb = $this->createQueryBuilder('self');
        $qb
            ->where('self.country = :country')
            ->setParameter('country', $country)
            ->orderBy('self.' . $orderProperty, $orderDirection)
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
