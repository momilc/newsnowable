<?php

namespace App\Repository;

use App\Entity\Figure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class FigureRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Figure::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('f')
            ->where('f.something = :value')->setParameter('value', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
     * @param $figureId
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByIdJoinedToCategory($figureId)
    {
        return $this->createQueryBuilder('f')
            // f.category refers to the "category" property on figure
            ->innerJoin('f.category', 'c')
            // selects all the category data to avoid the query
            ->addSelect('c')
            ->andWhere('f.id = :id')
            ->setParameter('id', $figureId)
            ->getQuery()
            ->getOneOrNullResult();
    }
//    public function findAllGreaterThanPrice($price): array
//    {
//        // automatically knows to select Products
//        // the "p" is an alias you'll use in the rest of the query
//        $qb = $this->createQueryBuilder('p')
//            ->andWhere('p.price > :price')
//            ->setParameter('price', $price)
//            ->orderBy('p.price', 'ASC')
//            ->getQuery();
//
//        return $qb->execute();
//
//        // to get just one result:
//        // $product = $qb->setMaxResults(1)->getOneOrNullResult();
//    }
}
