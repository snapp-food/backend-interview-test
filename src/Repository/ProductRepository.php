<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function paginateByRestaurant(Restaurant $restaurant, $page, $limit = 20)
    {
        $query = $this->createQueryBuilder('product')
            ->where('product.restaurant = :restaurant')
            ->setParameter('restaurant', $restaurant)
            ->getQuery();

        $paginator = new Paginator($query);
        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        return $paginator;
    }

    public function save(Product $product)
    {
        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();
    }

    public function delete(Product $product)
    {
        $this->getEntityManager()->remove($product);
        $this->getEntityManager()->flush();
    }
}
