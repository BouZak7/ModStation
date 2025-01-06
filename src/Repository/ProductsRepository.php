<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Products>
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

        /**
        * @return Products[] Returns an array of Products objects
        */
        public function findByService($value): array
        {
            return $this->createQueryBuilder('p')
                ->andWhere('p.service = :val')
                ->setParameter('val', $value)
                ->orderBy('p.id', 'ASC')
                ->setMaxResults(12)
                ->getQuery()
                ->getResult()
            ;
        }

        // /**
        // * @return Products[] Returns an array of Products objects
        // */
        // public function findByCategorie($value): array
        // {
        //     return $this->createQueryBuilder('p')
        //         ->andWhere('p.categorie = :val')
        //         ->setParameter('val', $value)
        //         ->orderBy('p.id', 'ASC')
        //         ->setMaxResults(12)
        //         ->getQuery()
        //         ->getResult()
        //     ;
        // }

        /**
        * @return Products[] Returns an array of Products objects
        */
        public function findByCategory(string $categoryName): array
        {
            return $this->createQueryBuilder('p')
                ->join('p.categorie', 'c') // Jointure avec la table Category
                ->andWhere('c.categorie = :categoryName') // Filtre par nom de la catégorie
                ->setParameter('categoryName', $categoryName)
                ->orderBy('p.id', 'ASC')
                ->setMaxResults(12)
                ->getQuery()
                ->getResult();
        }

    //    /**
    //     * @return Products[] Returns an array of Products objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Products
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
