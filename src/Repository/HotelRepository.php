<?php

namespace App\Repository;

use App\Entity\City;
use App\Entity\Hotel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hotel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hotel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hotel[]    findAll()
 * @method Hotel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HotelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hotel::class);
    }

    public function findByIds(array $ids): array
    {
        $results = [];
        foreach ($this->findBy(['id' => $ids]) as $item) {
            $results[$item->getId()] = $item;
        }
        return $results;
    }

    public function getPage(
        City $city,
        int $page,
        int $pageSize,
        string $orderProperty,
        string $orderDirection
    ): Paginator
    {
        $qb = $this->createQueryBuilder('self');
        $qb
            ->where('self.city = :city')
            ->setParameter('city', $city)
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
