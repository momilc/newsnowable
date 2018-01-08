<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('c')
            ->where('c.something = :value')->setParameter('value', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    /**
     * @param $categoryId
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByIdJoinedToFigure($categoryId)
    {
        return $this->createQueryBuilder('c')
            // c.figures refers to the "Figure" property on Category
            ->innerJoin('c.figures', 'f')
            // selects all the category data to avoid the query
            ->addSelect('f')
            ->andWhere('f.id = :id')
            ->setParameter('id', $categoryId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
