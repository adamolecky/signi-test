<?php

namespace App\Repository;

use App\Entity\Colour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Colour>
 *
 * @method Colour|null find($id, $lockMode = null, $lockVersion = null)
 * @method Colour|null findOneBy(array $criteria, array $orderBy = null)
 * @method Colour[]    findAll()
 * @method Colour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ColourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Colour::class);
    }


    /**
     * @param int[] $ids
     * @return Colour[]|null
     */
    public function findByIds(array $ids): ?array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();
    }
}
